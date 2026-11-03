<?php

namespace App\Http\Controllers;

use App\Exports\PaletMasukExport;
use App\Models\PaletMutasi;
use App\Models\PaletMutasiInternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PaletMutasiController extends Controller
{
    private const TANGGAL_MULAI_PERHITUNGAN = '2026-10-01';

    public function index(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|date_format:Y-m',
        ]);
        $bulan = $request->input('bulan', now()->format('Y-m'));
        $tanggalMulai = \Carbon\Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()->toDateString();
        $tanggalAkhir = \Carbon\Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->toDateString();

        $riwayat = DB::query()->fromSub(
            $this->queryKeluar()
                ->unionAll($this->queryMasuk())
                ->unionAll($this->queryInternalLegacy())
                ->unionAll($this->queryInternalMaster()),
            'mutasi'
        )
            ->whereDate('tanggal', '>=', self::TANGGAL_MULAI_PERHITUNGAN)
            ->orderBy('tanggal', 'desc')
            ->orderBy('noDokumen', 'desc');

        if ($request->filled('kategori')) {
            $riwayat->where('kategori', $request->kategori);
        }
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
        $saldoInternal = $this->hitungRekapBulananInternal($tanggalMulai, $tanggalAkhir);
        $tanggalSaldoAwal = DB::table('palet_mutasi_internal_m')
            ->where('sumber', PaletMutasi::SALDO_AWAL)
            ->whereNull('deletedAt')
            ->min('tanggal');
        $tanggalSaldoAwal = $tanggalSaldoAwal
            ? \Carbon\Carbon::parse($tanggalSaldoAwal)->toDateString()
            : null;

        return view('admin.palet_mutasi.index', compact(
            'mutasi',
            'saldo',
            'saldoInternal',
            'bulan',
            'tanggalMulai',
            'tanggalAkhir',
            'tanggalSaldoAwal'
        ));
    }

    public function export(Request $request)
    {
        $query = $this->queryMasuk()
            ->whereDate('pm.tanggal', '>=', self::TANGGAL_MULAI_PERHITUNGAN)
            ->orderBy('pm.tanggal')
            ->orderBy('pm.id');

        if ($request->filled('customer')) {
            $query->where('pm.namaCustomer', 'LIKE', '%' . $request->customer . '%');
        }
        if ($request->filled('start_date')) {
            $query->whereDate('pm.tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('pm.tanggal', '<=', $request->end_date);
        }

        return Excel::download(
            new PaletMasukExport($query->get()),
            'palet_masuk_' . date('Ymd_His') . '.xlsx'
        );
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

    public function createInternal()
    {
        $palets = DB::table('item_palet')
            ->whereNull('deletedAt')
            ->orderBy('nama')
            ->orderBy('ukuran')
            ->get(['id', 'nama', 'ukuran']);
        $details = collect();

        return view('admin.palet_mutasi.internal', compact('palets', 'details'));
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

    public function storeInternal(Request $request)
    {
        $data = $this->validateInternalRequest($request);
        if ($data['sumber'] === PaletMutasi::SALDO_AWAL) {
            if (\Carbon\Carbon::parse($data['tanggal'])->day !== 1) {
                return back()->withInput()->withErrors([
                    'tanggal' => 'Tanggal saldo awal harus tanggal 1 pada bulan mulai perhitungan.',
                ]);
            }
            if (PaletMutasiInternal::aktif()->where('sumber', PaletMutasi::SALDO_AWAL)->exists()) {
                return back()->withInput()->withErrors([
                    'sumber' => 'Saldo awal sudah pernah dicatat. Silakan edit transaksi saldo awal yang sudah ada.',
                ]);
            }
        }

        $invalidDetail = $this->findInvalidInternalDetail($data);
        if ($invalidDetail !== null) {
            return back()->withInput()->withErrors([
                "details.{$invalidDetail}.item_palet_id" => 'Tipe palet yang dipilih tidak aktif atau tidak ditemukan.',
            ]);
        }

        DB::transaction(function () use ($data) {
            $master = PaletMutasiInternal::create([
                'tanggal' => $data['tanggal'],
                'sumber' => $data['sumber'],
                'createdBy' => Auth::user()->name,
            ]);
            $this->saveInternalDetails($master, $data['details']);
        });

        return redirect()->route('palet_mutasi')
            ->with('success', 'Mutasi palet internal berhasil dicatat.');
    }

    public function edit($id)
    {
        $mutasi = PaletMutasi::aktif()
            ->where('jenis', PaletMutasi::MASUK)
            ->findOrFail($id);

        $customers = DB::connection('firebird')->table('TCustomer')
            ->orderBy('Nama')
            ->get(['Nama']);
        $palets = DB::table('item_palet')
            ->where(function ($query) use ($mutasi) {
                $query->whereNull('deletedAt')
                    ->orWhere('id', $mutasi->item_palet_id);
            })
            ->orderBy('nama')
            ->orderBy('ukuran')
            ->get(['id', 'nama', 'ukuran']);

        return view('admin.palet_mutasi.create', compact('customers', 'palets', 'mutasi'));
    }

    public function update(Request $request, $id)
    {
        $mutasi = PaletMutasi::aktif()
            ->where('jenis', PaletMutasi::MASUK)
            ->findOrFail($id);

        $data = $request->validate([
            'tanggal' => 'required|date',
            'namaCustomer' => 'required|string|max:255',
            'noPolisi' => 'required|string|max:100',
            'jenisPalet' => 'required|in:Kayu,Plastik',
            'item_palet_id' => 'required|integer|exists:item_palet,id',
            'qty_bagus' => 'required|integer|min:0',
            'qty_jelek' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $paletAktif = DB::table('item_palet')
            ->where('id', $data['item_palet_id'])
            ->where(function ($query) use ($mutasi, $data) {
                $query->whereNull('deletedAt');
                if ((int) $data['item_palet_id'] === (int) $mutasi->item_palet_id) {
                    $query->orWhere('id', $mutasi->item_palet_id);
                }
            })
            ->exists();

        if (!$paletAktif) {
            return back()->withInput()->withErrors([
                'item_palet_id' => 'Tipe palet yang dipilih tidak aktif atau tidak ditemukan.',
            ]);
        }

        $qty = $data['qty_bagus'] + $data['qty_jelek'];
        if ($qty < 1) {
            return back()->withInput()->withErrors([
                'qty_bagus' => 'Jumlah bagus dan jelek harus lebih dari 0.',
            ]);
        }

        $mutasi->update([
            'tanggal' => $data['tanggal'],
            'namaCustomer' => $data['namaCustomer'],
            'noPolisi' => $data['noPolisi'],
            'jenisPalet' => $data['jenisPalet'],
            'item_palet_id' => $data['item_palet_id'],
            'qty' => $qty,
            'qty_bagus' => $data['qty_bagus'],
            'qty_jelek' => $data['qty_jelek'],
            'keterangan' => $data['keterangan'] ?? null,
            'lastUpdatedBy' => Auth::user()->name,
        ]);

        return redirect()->route('palet_mutasi')
            ->with('success', 'Catatan palet masuk berhasil diperbarui.');
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

    public function editInternal($id)
    {
        $mutasi = PaletMutasiInternal::aktif()->with('details')->findOrFail($id);
        $palets = DB::table('item_palet')
            ->where(function ($query) use ($mutasi) {
                $query->whereNull('deletedAt')
                    ->orWhereIn('id', $mutasi->details->pluck('item_palet_id'));
            })
            ->orderBy('nama')
            ->orderBy('ukuran')
            ->get(['id', 'nama', 'ukuran']);

        $details = $mutasi->details;

        return view('admin.palet_mutasi.internal', compact('mutasi', 'details', 'palets'));
    }

    public function updateInternal(Request $request, $id)
    {
        $mutasi = PaletMutasiInternal::aktif()->with('details')->findOrFail($id);
        $data = $this->validateInternalRequest($request);
        if ($data['sumber'] === PaletMutasi::SALDO_AWAL
            && \Carbon\Carbon::parse($data['tanggal'])->day !== 1) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Tanggal saldo awal harus tanggal 1 pada bulan mulai perhitungan.',
            ]);
        }
        if ($data['sumber'] === PaletMutasi::SALDO_AWAL
            && PaletMutasiInternal::aktif()
                ->where('sumber', PaletMutasi::SALDO_AWAL)
                ->where('id', '!=', $mutasi->id)
                ->exists()) {
            return back()->withInput()->withErrors([
                'sumber' => 'Saldo awal sudah pernah dicatat. Hanya boleh ada satu transaksi saldo awal aktif.',
            ]);
        }
        $existingPaletIds = $mutasi->details->pluck('item_palet_id')->map(function ($id) {
            return (int) $id;
        })->all();
        $invalidDetail = $this->findInvalidInternalDetail($data, $existingPaletIds);
        if ($invalidDetail !== null) {
            return back()->withInput()->withErrors([
                "details.{$invalidDetail}.item_palet_id" => 'Tipe palet yang dipilih tidak aktif atau tidak ditemukan.',
            ]);
        }

        DB::transaction(function () use ($mutasi, $data) {
            $mutasi->update([
                'tanggal' => $data['tanggal'],
                'sumber' => $data['sumber'],
                'lastUpdatedBy' => Auth::user()->name,
            ]);
            $mutasi->details()->delete();
            $this->saveInternalDetails($mutasi, $data['details']);
        });

        return redirect()->route('palet_mutasi')
            ->with('success', 'Mutasi palet internal berhasil diperbarui.');
    }

    public function destroyInternal($id)
    {
        $mutasi = PaletMutasiInternal::aktif()->findOrFail($id);
        $mutasi->update([
            'deletedAt' => now(),
            'deletedBy' => Auth::user()->name,
        ]);

        return redirect()->route('palet_mutasi')
            ->with('success', 'Mutasi palet internal dihapus.');
    }

    private function validateInternalRequest(Request $request): array
    {
        return $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required|in:' . implode(',', [
                PaletMutasi::PEMBELIAN,
                PaletMutasi::RETUR_PEMAKAIAN,
                PaletMutasi::PEMAKAIAN,
                PaletMutasi::SALDO_AWAL,
                PaletMutasi::RETUR_BELI,
            ]),
            'details' => 'required|array|min:1',
            'details.*.item_palet_id' => 'required|integer|exists:item_palet,id',
            'details.*.qty' => 'required|integer|min:1',
        ]);
    }

    private function findInvalidInternalDetail(array $data, array $existingPaletIds = []): ?int
    {
        $itemPaletIds = collect($data['details'])->pluck('item_palet_id')->unique();
        $activePaletIds = DB::table('item_palet')
            ->whereNull('deletedAt')
            ->whereIn('id', $itemPaletIds)
            ->pluck('id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->all();

        foreach ($data['details'] as $index => $detail) {
            $itemPaletId = (int) $detail['item_palet_id'];
            if (!in_array($itemPaletId, $activePaletIds, true)
                && !in_array($itemPaletId, $existingPaletIds, true)) {
                return $index;
            }
        }

        return null;
    }

    private function saveInternalDetails(PaletMutasiInternal $master, array $details): void
    {
        foreach ($details as $detail) {
            $master->details()->create([
                'item_palet_id' => $detail['item_palet_id'],
                'qty' => $detail['qty'],
            ]);
        }
    }

    private function queryKeluar()
    {
        return DB::table('sj_palet_d as d')
            ->join('sj_palet_m as m', 'd.sj_palet_m_id', '=', 'm.id')
            ->join('item_palet as p', 'd.item_palet_id', '=', 'p.id')
            ->whereNull('m.deletedAt')
            ->whereNull('d.deletedAt')
            ->selectRaw("m.tanggal, 'keluar' as jenis, 'customer' as kategori, 'sj_palet' as sumber,
                m.namaCustomer, NULL as jenisPalet, p.nama as palet, p.ukuran, d.qty,
                NULL as qty_bagus, NULL as qty_jelek, m.noSuratJalan as noDokumen, m.noPolisi,
                d.keterangan, m.createdBy, NULL as mutasi_id, NULL as internal_master_id");
    }

    private function queryMasuk()
    {
        return DB::table('palet_mutasi as pm')
            ->join('item_palet as p', 'pm.item_palet_id', '=', 'p.id')
            ->where('pm.jenis', PaletMutasi::MASUK)
            ->where('pm.kategori', PaletMutasi::CUSTOMER)
            ->whereNull('pm.deletedAt')
            ->selectRaw("pm.tanggal, pm.jenis, pm.kategori, pm.sumber, pm.namaCustomer, pm.jenisPalet,
                p.nama as palet, p.ukuran, pm.qty, pm.qty_bagus, pm.qty_jelek, pm.noDokumen,
                pm.noPolisi, pm.keterangan, pm.createdBy, pm.id as mutasi_id, NULL as internal_master_id");
    }

    private function queryInternalLegacy()
    {
        return DB::table('palet_mutasi as pm')
            ->join('item_palet as p', 'pm.item_palet_id', '=', 'p.id')
            ->where('pm.kategori', PaletMutasi::INTERNAL)
            ->whereNull('pm.deletedAt')
            ->selectRaw("pm.tanggal, pm.jenis, pm.kategori, pm.sumber, pm.namaCustomer, pm.jenisPalet,
                p.nama as palet, p.ukuran, pm.qty, pm.qty_bagus, pm.qty_jelek, pm.noDokumen,
                pm.noPolisi, pm.keterangan, pm.createdBy, pm.id as mutasi_id, NULL as internal_master_id");
    }

    private function queryInternalMaster()
    {
        return DB::table('palet_mutasi_internal_m as m')
            ->join('palet_mutasi_internal_d as d', 'd.palet_mutasi_internal_m_id', '=', 'm.id')
            ->join('item_palet as p', 'd.item_palet_id', '=', 'p.id')
            ->whereNull('m.deletedAt')
            ->selectRaw("m.tanggal,
                CASE WHEN m.sumber IN ('pemakaian', 'retur_beli') THEN 'keluar' ELSE 'masuk' END as jenis,
                'internal' as kategori, m.sumber, 'Internal' as namaCustomer,
                NULL as jenisPalet, p.nama as palet, p.ukuran, d.qty, NULL as qty_bagus, NULL as qty_jelek,
                NULL as noDokumen, NULL as noPolisi, NULL as keterangan, m.createdBy,
                NULL as mutasi_id, m.id as internal_master_id");
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

    private function queryArusStok()
    {
        $internalLegacy = DB::table('palet_mutasi as pm')
            ->where('pm.kategori', PaletMutasi::INTERNAL)
            ->whereNull('pm.deletedAt')
            ->selectRaw('pm.tanggal, pm.item_palet_id, pm.qty, pm.jenis, pm.sumber, pm.kategori');
        $internalMaster = DB::table('palet_mutasi_internal_m as m')
            ->join('palet_mutasi_internal_d as d', 'd.palet_mutasi_internal_m_id', '=', 'm.id')
            ->whereNull('m.deletedAt')
            ->selectRaw("m.tanggal, d.item_palet_id, d.qty,
                CASE WHEN m.sumber IN ('pemakaian', 'retur_beli') THEN 'keluar' ELSE 'masuk' END as jenis,
                m.sumber, 'internal' as kategori");
        $pengembalianCustomer = DB::table('palet_mutasi as pm')
            ->where('pm.kategori', PaletMutasi::CUSTOMER)
            ->where('pm.jenis', PaletMutasi::MASUK)
            ->whereNull('pm.deletedAt')
            ->selectRaw("pm.tanggal, pm.item_palet_id, pm.qty, pm.jenis, 'pengembalian_customer' as sumber, pm.kategori");
        $pengeluaranCustomer = DB::table('sj_palet_d as d')
            ->join('sj_palet_m as m', 'd.sj_palet_m_id', '=', 'm.id')
            ->whereNull('m.deletedAt')
            ->whereNull('d.deletedAt')
            ->selectRaw("m.tanggal, d.item_palet_id, d.qty, 'keluar' as jenis,
                'pengeluaran_customer' as sumber, 'customer' as kategori");

        return $internalLegacy
            ->unionAll($internalMaster)
            ->unionAll($pengembalianCustomer)
            ->unionAll($pengeluaranCustomer);
    }

    private function hitungRekapBulananInternal(string $tanggalMulai, string $tanggalAkhir)
    {
        $palets = DB::table('item_palet')
            ->whereNull('deletedAt')
            ->orderBy('nama')
            ->orderBy('ukuran')
            ->get(['id', 'nama', 'ukuran'])
            ->keyBy('id');
        $rekap = [];
        foreach ($palets as $palet) {
            $rekap[$palet->id] = (object) [
                'palet' => $palet->nama,
                'ukuran' => $palet->ukuran,
                'saldo_awal' => 0,
                'pembelian' => 0,
                'pengembalian_customer' => 0,
                'pemakaian' => 0,
                'pengeluaran_customer' => 0,
                'retur_pemakaian' => 0,
                'retur_beli' => 0,
                'saldo_akhir' => 0,
            ];
        }

        $saldoAwalTanggal = DB::table('palet_mutasi_internal_m')
            ->where('sumber', PaletMutasi::SALDO_AWAL)
            ->whereNull('deletedAt')
            ->min('tanggal');

        if (!$saldoAwalTanggal || $saldoAwalTanggal > $tanggalMulai) {
            return collect($rekap)->values();
        }

        $mutasi = DB::query()->fromSub($this->queryArusStok(), 'arus')
            ->whereDate('tanggal', '>=', $saldoAwalTanggal)
            ->whereDate('tanggal', '<=', $tanggalAkhir)
            ->where('sumber', '!=', PaletMutasi::SALDO_AWAL)
            ->get();
        $saldoAwal = DB::query()->fromSub($this->queryArusStok(), 'arus')
            ->where('sumber', PaletMutasi::SALDO_AWAL)
            ->whereDate('tanggal', '<=', $tanggalMulai)
            ->get();

        foreach ($saldoAwal as $row) {
            if (isset($rekap[$row->item_palet_id])) {
                $rekap[$row->item_palet_id]->saldo_awal += (int) $row->qty;
            }
        }

        foreach ($mutasi as $row) {
            if (!isset($rekap[$row->item_palet_id])) {
                continue;
            }

            $qty = (int) $row->qty;
            $isBeforePeriod = $row->tanggal < $tanggalMulai;
            if ($isBeforePeriod) {
                $rekap[$row->item_palet_id]->saldo_awal += $row->jenis === PaletMutasi::MASUK ? $qty : -$qty;
                continue;
            }

            $kolom = $row->sumber;
            if (isset($rekap[$row->item_palet_id]->{$kolom})) {
                $rekap[$row->item_palet_id]->{$kolom} += $qty;
            }
        }

        foreach ($rekap as $row) {
            $row->saldo_akhir = $row->saldo_awal
                + $row->pembelian
                + $row->pengembalian_customer
                + $row->retur_pemakaian
                - $row->pemakaian
                - $row->pengeluaran_customer
                - $row->retur_beli;
        }

        return collect($rekap)->values();
    }
}
