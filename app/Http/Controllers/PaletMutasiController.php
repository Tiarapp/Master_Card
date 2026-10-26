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
        $customers = DB::connection('firebird')->table('TCustomer')
            ->orderBy('Nama')
            ->get(['Nama']);

        return view('admin.palet_mutasi.create', compact('customers'));
    }

    public function paletOptions(Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|string',
        ]);

        $items = DB::table('sj_palet_m as m')
            ->join('sj_palet_d as d', 'm.id', '=', 'd.sj_palet_m_id')
            ->join('item_palet as p', 'd.item_palet_id', '=', 'p.id')
            ->whereNull('m.deletedAt')
            ->whereNull('d.deletedAt')
            ->where('m.namaCustomer', $data['customer'])
            ->groupBy('m.id', 'm.noSuratJalan', 'm.tanggal', 'd.item_palet_id', 'p.nama', 'p.ukuran')
            ->orderBy('m.tanggal')
            ->orderBy('m.noSuratJalan')
            ->get([
                'm.id as sj_palet_m_id',
                'm.noSuratJalan',
                'm.tanggal',
                'd.item_palet_id',
                'p.nama',
                'p.ukuran',
                DB::raw('SUM(d.qty) as qty'),
            ]);

        $dikembalikan = PaletMutasi::aktif()
            ->where('jenis', PaletMutasi::MASUK)
            ->whereIn('sj_palet_m_id', $items->pluck('sj_palet_m_id')->unique())
            ->groupBy('sj_palet_m_id', 'item_palet_id')
            ->selectRaw('sj_palet_m_id, item_palet_id, SUM(qty) as total')
            ->get()
            ->keyBy(function ($row) {
                return $row->sj_palet_m_id . ':' . $row->item_palet_id;
            });

        return response()->json($items->map(function ($item) use ($dikembalikan) {
            $key = $item->sj_palet_m_id . ':' . $item->item_palet_id;
            $item->dikembalikan = (int) ($dikembalikan[$key]->total ?? 0);
            $item->sisa = max(0, (int) $item->qty - $item->dikembalikan);

            return $item;
        })->filter(function ($item) {
            return $item->sisa > 0;
        })->values());
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
            'tanggal' => 'required|date',
            'namaCustomer' => 'required|string|max:255',
            'noPolisi' => 'required|string|max:100',
            'jenisPalet' => 'required|in:Kayu,Plastik',
            'details' => 'required|array|min:1',
            'details.*.sj_palet_m_id' => 'required|integer|exists:sj_palet_m,id',
            'details.*.item_palet_id' => 'required|integer|exists:item_palet,id',
            'details.*.qty_bagus' => 'required|integer|min:0',
            'details.*.qty_jelek' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        foreach ($data['details'] as $index => $detail) {
            if ($detail['qty_bagus'] + $detail['qty_jelek'] < 1) {
                return back()->withInput()->withErrors([
                    "details.{$index}.qty_bagus" => 'Jumlah bagus dan jelek harus lebih dari 0.',
                ]);
            }
        }

        $sourceRows = DB::table('sj_palet_m as m')
            ->join('sj_palet_d as d', 'm.id', '=', 'd.sj_palet_m_id')
            ->whereNull('m.deletedAt')
            ->whereNull('d.deletedAt')
            ->where('m.namaCustomer', $data['namaCustomer'])
            ->whereIn('m.id', collect($data['details'])->pluck('sj_palet_m_id')->unique())
            ->groupBy('m.id', 'm.noSuratJalan', 'd.item_palet_id')
            ->selectRaw('m.id as sj_palet_m_id, m.noSuratJalan, d.item_palet_id, SUM(d.qty) as qty')
            ->get()
            ->keyBy(function ($row) {
                return $row->sj_palet_m_id . ':' . $row->item_palet_id;
            });

        $requested = collect($data['details'])->groupBy(function ($detail) {
            return $detail['sj_palet_m_id'] . ':' . $detail['item_palet_id'];
        });

        $alreadyReturned = PaletMutasi::aktif()
            ->where('jenis', PaletMutasi::MASUK)
            ->whereIn('sj_palet_m_id', collect($data['details'])->pluck('sj_palet_m_id')->unique())
            ->groupBy('sj_palet_m_id', 'item_palet_id')
            ->selectRaw('sj_palet_m_id, item_palet_id, SUM(qty) as total')
            ->get()
            ->keyBy(function ($row) {
                return $row->sj_palet_m_id . ':' . $row->item_palet_id;
            });

        foreach ($requested as $key => $details) {
            $source = $sourceRows[$key] ?? null;
            if (!$source) {
                return back()->withInput()->withErrors([
                    'details' => 'Data palet tidak ditemukan pada SJ customer yang dipilih.',
                ]);
            }

            $quantity = $details->sum(function ($detail) {
                return $detail['qty_bagus'] + $detail['qty_jelek'];
            });
            $returned = (int) ($alreadyReturned[$key]->total ?? 0);

            if ($returned + $quantity > (int) $source->qty) {
                return back()->withInput()->withErrors([
                    'details' => "Jumlah palet melebihi sisa pada SJ {$source->noSuratJalan}.",
                ]);
            }
        }

        DB::transaction(function () use ($data, $sourceRows) {
            foreach ($data['details'] as $detail) {
                $source = $sourceRows[$detail['sj_palet_m_id'] . ':' . $detail['item_palet_id']];
                $qty = $detail['qty_bagus'] + $detail['qty_jelek'];

                PaletMutasi::create([
                    'tanggal' => $data['tanggal'],
                    'jenis' => PaletMutasi::MASUK,
                    'namaCustomer' => $data['namaCustomer'],
                    'jenisPalet' => $data['jenisPalet'],
                    'item_palet_id' => $detail['item_palet_id'],
                    'sj_palet_m_id' => $detail['sj_palet_m_id'],
                    'qty' => $qty,
                    'qty_bagus' => $detail['qty_bagus'],
                    'qty_jelek' => $detail['qty_jelek'],
                    'noDokumen' => $source->noSuratJalan,
                    'noPolisi' => $data['noPolisi'],
                    'keterangan' => $data['keterangan'] ?? null,
                    'createdBy' => Auth::user()->name,
                ]);
            }
        });

        return redirect()->route('palet_mutasi')
            ->with('success', 'Palet masuk dari customer berhasil dicatat.');
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
            ->selectRaw("m.tanggal, 'keluar' as jenis, m.namaCustomer, NULL as jenisPalet, p.nama as palet, p.ukuran, d.qty,
                NULL as qty_bagus, NULL as qty_jelek, m.noSuratJalan as noDokumen, m.noPolisi, d.keterangan, m.createdBy, NULL as mutasi_id");
    }

    private function queryMasuk()
    {
        return DB::table('palet_mutasi as pm')
            ->join('item_palet as p', 'pm.item_palet_id', '=', 'p.id')
            ->where('pm.jenis', PaletMutasi::MASUK)
            ->whereNull('pm.deletedAt')
            ->selectRaw("pm.tanggal, 'masuk' as jenis, pm.namaCustomer, pm.jenisPalet, p.nama as palet, p.ukuran, pm.qty,
                pm.qty_bagus, pm.qty_jelek, pm.noDokumen, pm.noPolisi, pm.keterangan, pm.createdBy, pm.id as mutasi_id");
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
