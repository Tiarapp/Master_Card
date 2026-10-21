<?php

namespace App\Http\Controllers;

use App\Models\PaletMutasi;
use App\Models\SJ_Palet_D;
use App\Models\SJ_Palet_M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaletMutasiController extends Controller
{
    public function index(Request $request)
    {
        $query = PaletMutasi::aktif()->with('palet')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('customer')) {
            $query->where('namaCustomer', 'LIKE', '%' . $request->customer . '%');
        }
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $mutasi = $query->paginate(50)->appends($request->query());

        // Saldo = palet keluar - palet masuk, yaitu palet yang masih ada di customer
        $saldoQuery = DB::table('palet_mutasi')
            ->join('item_palet', 'palet_mutasi.item_palet_id', '=', 'item_palet.id')
            ->whereNull('palet_mutasi.deletedAt')
            ->groupBy('palet_mutasi.namaCustomer', 'item_palet.id', 'item_palet.nama', 'item_palet.ukuran')
            ->orderBy('palet_mutasi.namaCustomer')
            ->selectRaw("palet_mutasi.namaCustomer, item_palet.nama as palet, item_palet.ukuran,
                SUM(CASE WHEN palet_mutasi.jenis = 'keluar' THEN palet_mutasi.qty ELSE 0 END) as total_keluar,
                SUM(CASE WHEN palet_mutasi.jenis = 'masuk' THEN palet_mutasi.qty ELSE 0 END) as total_masuk");

        if ($request->filled('customer')) {
            $saldoQuery->where('palet_mutasi.namaCustomer', 'LIKE', '%' . $request->customer . '%');
        }

        $saldo = $saldoQuery->get();

        return view('admin.palet_mutasi.index', compact('mutasi', 'saldo'));
    }

    public function create(Request $request)
    {
        $jenis = $request->get('jenis') === PaletMutasi::MASUK ? PaletMutasi::MASUK : PaletMutasi::KELUAR;

        $sjQuery = SJ_Palet_M::whereNull('deletedAt')->orderBy('tanggal', 'desc')->orderBy('noSuratJalan', 'desc');

        // SJ yang sudah dicatat keluar tidak ditawarkan lagi agar tidak tercatat ganda
        if ($jenis === PaletMutasi::KELUAR) {
            $sjQuery->whereNotIn('id', $this->sjSudahKeluar());
        }

        $sjList = $sjQuery->limit(500)->get(['id', 'noSuratJalan', 'tanggal', 'namaCustomer']);

        return view('admin.palet_mutasi.create', compact('jenis', 'sjList'));
    }

    public function sjDetail($id)
    {
        $sj = SJ_Palet_M::whereNull('deletedAt')->findOrFail($id);

        $dikembalikan = PaletMutasi::aktif()
            ->where('sj_palet_m_id', $sj->id)
            ->where('jenis', PaletMutasi::MASUK)
            ->groupBy('item_palet_id')
            ->selectRaw('item_palet_id, SUM(qty) as total')
            ->pluck('total', 'item_palet_id');

        $items = DB::table('sj_palet_d')
            ->join('item_palet', 'sj_palet_d.item_palet_id', '=', 'item_palet.id')
            ->where('sj_palet_d.sj_palet_m_id', $sj->id)
            ->whereNull('sj_palet_d.deletedAt')
            ->get(['sj_palet_d.item_palet_id', 'item_palet.nama', 'item_palet.ukuran', 'sj_palet_d.qty', 'sj_palet_d.noKontrak'])
            ->map(function ($row) use ($dikembalikan) {
                $row->dikembalikan = (int) ($dikembalikan[$row->item_palet_id] ?? 0);

                return $row;
            });

        return response()->json([
            'noSuratJalan' => $sj->noSuratJalan,
            'tanggal' => $sj->tanggal,
            'namaCustomer' => $sj->namaCustomer,
            'noPolisi' => $sj->noPolisi,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:keluar,masuk',
            'sj_palet_m_id' => 'required|exists:sj_palet_m,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $sj = SJ_Palet_M::whereNull('deletedAt')->findOrFail($request->sj_palet_m_id);
        $base = [
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'namaCustomer' => $sj->namaCustomer,
            'sj_palet_m_id' => $sj->id,
            'noDokumen' => $sj->noSuratJalan,
            'noPolisi' => $sj->noPolisi,
            'keterangan' => $request->keterangan,
            'createdBy' => Auth::user()->name,
        ];

        if ($request->jenis === PaletMutasi::KELUAR) {
            return $this->storeKeluar($sj, $base);
        }

        return $this->storeMasuk($request, $sj, $base);
    }

    private function storeKeluar(SJ_Palet_M $sj, array $base)
    {
        if ($this->sjSudahKeluar()->contains($sj->id)) {
            return back()->withInput()->withErrors(['sj_palet_m_id' => 'SJ Palet ini sudah dicatat sebagai palet keluar.']);
        }

        $details = SJ_Palet_D::where('sj_palet_m_id', $sj->id)->whereNull('deletedAt')->get();

        if ($details->isEmpty()) {
            return back()->withInput()->withErrors(['sj_palet_m_id' => 'SJ Palet ini tidak memiliki item palet.']);
        }

        DB::transaction(function () use ($details, $base) {
            foreach ($details as $detail) {
                PaletMutasi::create($base + [
                    'item_palet_id' => $detail->item_palet_id,
                    'qty' => $detail->qty,
                ]);
            }
        });

        return redirect()->route('palet_mutasi')->with('success', "Palet keluar dari SJ {$sj->noSuratJalan} berhasil dicatat.");
    }

    private function storeMasuk(Request $request, SJ_Palet_M $sj, array $base)
    {
        $data = $request->validate([
            'item_palet_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
        ]);

        $itemDiSj = SJ_Palet_D::where('sj_palet_m_id', $sj->id)
            ->where('item_palet_id', $data['item_palet_id'])
            ->whereNull('deletedAt')
            ->exists();

        if (!$itemDiSj) {
            return back()->withInput()->withErrors(['item_palet_id' => 'Palet tidak ada di SJ Palet yang dipilih.']);
        }

        PaletMutasi::create($base + $data);

        return redirect()->route('palet_mutasi')->with('success', "Palet masuk dari customer (ref. SJ {$sj->noSuratJalan}) berhasil dicatat.");
    }

    private function sjSudahKeluar()
    {
        return PaletMutasi::aktif()
            ->where('jenis', PaletMutasi::KELUAR)
            ->whereNotNull('sj_palet_m_id')
            ->pluck('sj_palet_m_id')
            ->unique()
            ->values();
    }

    public function destroy($id)
    {
        $mutasi = PaletMutasi::aktif()->findOrFail($id);
        $mutasi->update([
            'deletedAt' => now(),
            'deletedBy' => Auth::user()->name,
        ]);

        return redirect()->route('palet_mutasi')->with('success', 'Catatan palet dihapus.');
    }
}
