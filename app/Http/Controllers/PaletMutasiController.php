<?php

namespace App\Http\Controllers;

use App\Models\PaletMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaletMutasiController extends Controller
{
    private const TANGGAL_MULAI_PERHITUNGAN = '2026-10-01';

    public function index(Request $request)
    {
        // Palet keluar dibaca langsung dari SJ Palet, palet masuk dari catatan manual
        $riwayat = DB::query()->fromSub($this->queryKeluar()->unionAll($this->queryMasuk()), 'mutasi')
            ->whereDate('tanggal', '>=', self::TANGGAL_MULAI_PERHITUNGAN)
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
        $palets = DB::table('item_palet')
            ->whereNull('deletedAt')
            ->orderBy('nama')
            ->orderBy('ukuran')
            ->get(['id', 'nama', 'ukuran']);

        return view('admin.palet_mutasi.create', compact('customers', 'palets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'namaCustomer' => 'required|string|max:255',
            'noPolisi' => 'required|string|max:100',
            'jenisPalet' => 'required|in:Kayu,Plastik',
            'details' => 'required|array|min:1',
            'details.*.item_palet_id' => 'required|integer|exists:item_palet,id',
            'details.*.qty_bagus' => 'required|integer|min:0',
            'details.*.qty_jelek' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $activePaletIds = DB::table('item_palet')
            ->whereNull('deletedAt')
            ->whereIn('id', collect($data['details'])->pluck('item_palet_id')->unique())
            ->pluck('id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->all();

        foreach ($data['details'] as $index => $detail) {
            if (!in_array((int) $detail['item_palet_id'], $activePaletIds, true)) {
                return back()->withInput()->withErrors([
                    "details.{$index}.item_palet_id" => 'Tipe palet yang dipilih tidak aktif atau tidak ditemukan.',
                ]);
            }

            if ($detail['qty_bagus'] + $detail['qty_jelek'] < 1) {
                return back()->withInput()->withErrors([
                    "details.{$index}.qty_bagus" => 'Jumlah bagus dan jelek harus lebih dari 0.',
                ]);
            }
        }

        DB::transaction(function () use ($data) {
            foreach ($data['details'] as $detail) {
                $qty = $detail['qty_bagus'] + $detail['qty_jelek'];

                PaletMutasi::create([
                    'tanggal' => $data['tanggal'],
                    'jenis' => PaletMutasi::MASUK,
                    'namaCustomer' => $data['namaCustomer'],
                    'jenisPalet' => $data['jenisPalet'],
                    'item_palet_id' => $detail['item_palet_id'],
                    'qty' => $qty,
                    'qty_bagus' => $detail['qty_bagus'],
                    'qty_jelek' => $detail['qty_jelek'],
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
        $keluar = DB::query()->fromSub($this->queryKeluar(), 't')
            ->whereDate('tanggal', '>=', self::TANGGAL_MULAI_PERHITUNGAN);
        $masuk = DB::query()->fromSub($this->queryMasuk(), 't')
            ->whereDate('tanggal', '>=', self::TANGGAL_MULAI_PERHITUNGAN);

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
