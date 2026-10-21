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
        // Palet keluar dibaca langsung dari SJ Palet, palet masuk dari catatan manual
        $riwayat = DB::query()->fromSub($this->queryKeluar()->unionAll($this->queryMasuk()), 'mutasi')
            ->orderBy('tanggal', 'desc')
            ->orderBy('noDokumen', 'desc');

        if ($request->filled('jenis')) {
            $riwayat->where('jenis', $request->jenis);
        }
        if ($request->filled('customer')) {
            $riwayat->where('namaCustomer', 'LIKE', '%' . $request->customer . '%');
        }
        if ($request->filled('start_date')) {
            $riwayat->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $riwayat->whereDate('tanggal', '<=', $request->end_date);
        }

        $mutasi = $riwayat->paginate(50)->appends($request->query());
        $saldo = $this->hitungSaldo($request->input('customer'));

        return view('admin.palet_mutasi.index', compact('mutasi', 'saldo'));
    }

    public function create()
    {
        $sjList = SJ_Palet_M::whereNull('deletedAt')
            ->orderBy('tanggal', 'desc')
            ->orderBy('noSuratJalan', 'desc')
            ->limit(500)
            ->get(['id', 'noSuratJalan', 'tanggal', 'namaCustomer']);

        return view('admin.palet_mutasi.create', compact('sjList'));
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
        $data = $request->validate([
            'sj_palet_m_id' => 'required|exists:sj_palet_m,id',
            'tanggal' => 'required|date',
            'item_palet_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $sj = SJ_Palet_M::whereNull('deletedAt')->findOrFail($data['sj_palet_m_id']);

        $itemDiSj = SJ_Palet_D::where('sj_palet_m_id', $sj->id)
            ->where('item_palet_id', $data['item_palet_id'])
            ->whereNull('deletedAt')
            ->exists();

        if (!$itemDiSj) {
            return back()->withInput()->withErrors(['item_palet_id' => 'Palet tidak ada di SJ Palet yang dipilih.']);
        }

        PaletMutasi::create($data + [
            'jenis' => PaletMutasi::MASUK,
            'namaCustomer' => $sj->namaCustomer,
            'noDokumen' => $sj->noSuratJalan,
            'noPolisi' => $sj->noPolisi,
            'createdBy' => Auth::user()->name,
        ]);

        return redirect()->route('palet_mutasi')
            ->with('success', "Palet masuk dari customer (ref. SJ {$sj->noSuratJalan}) berhasil dicatat.");
    }

    public function destroy($id)
    {
        $mutasi = PaletMutasi::aktif()->where('jenis', PaletMutasi::MASUK)->findOrFail($id);
        $mutasi->update([
            'deletedAt' => now(),
            'deletedBy' => Auth::user()->name,
        ]);

        return redirect()->route('palet_mutasi')->with('success', 'Catatan palet masuk dihapus.');
    }

    private function queryKeluar()
    {
        return DB::table('sj_palet_d as d')
            ->join('sj_palet_m as m', 'd.sj_palet_m_id', '=', 'm.id')
            ->join('item_palet as p', 'd.item_palet_id', '=', 'p.id')
            ->whereNull('m.deletedAt')
            ->whereNull('d.deletedAt')
            ->selectRaw("m.tanggal, 'keluar' as jenis, m.namaCustomer, p.nama as palet, p.ukuran, d.qty,
                m.noSuratJalan as noDokumen, m.noPolisi, d.keterangan, m.createdBy, NULL as mutasi_id");
    }

    private function queryMasuk()
    {
        return DB::table('palet_mutasi as pm')
            ->join('item_palet as p', 'pm.item_palet_id', '=', 'p.id')
            ->where('pm.jenis', PaletMutasi::MASUK)
            ->whereNull('pm.deletedAt')
            ->selectRaw("pm.tanggal, 'masuk' as jenis, pm.namaCustomer, p.nama as palet, p.ukuran, pm.qty,
                pm.noDokumen, pm.noPolisi, pm.keterangan, pm.createdBy, pm.id as mutasi_id");
    }

    // Saldo = palet keluar (SJ Palet) - palet masuk, yaitu palet yang masih ada di customer
    private function hitungSaldo(?string $customer)
    {
        $keluar = DB::query()->fromSub($this->queryKeluar(), 't');
        $masuk = DB::query()->fromSub($this->queryMasuk(), 't');

        foreach ([$keluar, $masuk] as $q) {
            if ($customer) {
                $q->where('namaCustomer', 'LIKE', '%' . $customer . '%');
            }
            $q->groupBy('namaCustomer', 'palet', 'ukuran')
                ->selectRaw('namaCustomer, palet, ukuran, SUM(qty) as total');
        }

        $saldo = [];
        foreach ($keluar->get() as $row) {
            $key = $row->namaCustomer . '|' . $row->palet . '|' . $row->ukuran;
            $saldo[$key] = (object) [
                'namaCustomer' => $row->namaCustomer,
                'palet' => $row->palet,
                'ukuran' => $row->ukuran,
                'total_keluar' => (int) $row->total,
                'total_masuk' => 0,
            ];
        }
        foreach ($masuk->get() as $row) {
            $key = $row->namaCustomer . '|' . $row->palet . '|' . $row->ukuran;
            $saldo[$key] = $saldo[$key] ?? (object) [
                'namaCustomer' => $row->namaCustomer,
                'palet' => $row->palet,
                'ukuran' => $row->ukuran,
                'total_keluar' => 0,
                'total_masuk' => 0,
            ];
            $saldo[$key]->total_masuk = (int) $row->total;
        }

        return collect($saldo)->sortBy('namaCustomer')->values();
    }
}
