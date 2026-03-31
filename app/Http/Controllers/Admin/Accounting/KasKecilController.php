<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\COA;
use App\Models\Accounting\KasKecil;
use App\Models\Accounting\KasKecilDet;
use App\Models\Accounting\TrialBalance;
use App\Exports\KasKecilExport;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class KasKecilController extends Controller
{
    public function index(Request $request)
    {
        $coa = COA::where('kd_coa', 'like', '1101.01%')
                ->where('Kode_Bukti', '!=', null)
                ->get();
        
        $kasKecils = new KasKecilDet();
        $kasKecils = $kasKecils->with('kasKecil');

        // Get previous month period for saldo awal
        $saldoKasBulanLalu = null;
        if (!empty($request->date_start) && !empty($request->coa)) {
            $periodeBulanLalu = Carbon::parse($request->date_start)->subMonth()->format('m/Y');
            
            // Find COA record first, then call instance method
            $coaRecord = COA::where('Kode_Bukti', $request->coa)->first();
            if ($coaRecord) {
                $saldoKasBulanLalu = TrialBalance::where('Periode', $periodeBulanLalu)
                    ->where('KdCOA', 'like', $coaRecord->kd_coa . '%')
                    ->first();
            }
        }
        
        if (empty($request->date_start) || empty($request->date_end) || empty($request->coa)) {
            // Return empty paginated collection when parameters are missing
            $kasKecils = new LengthAwarePaginator(
                collect(), // empty collection
                0, // total items
                20, // per page
                1, // current page
                [
                    'path' => request()->url(),
                    'pageName' => 'page'
                ]
            );
        } else {
            // Calculate running balance for pagination
            $totalQuery = KasKecilDet::with('kasKecil')
                ->join('tbKasKecil', 'tbKasKecil_Detail.Nomor', '=', 'tbKasKecil.Nomor')
                ->whereBetween('tbKasKecil.Tanggal', [$request->date_start, $request->date_end])
                ->where('tbKasKecil_Detail.Nomor', 'like', '%' . $request->coa . '%')
                ->orderBy('tbKasKecil.Tanggal', 'asc');
                
            // Get paginated data
            $kasKecils = $totalQuery->paginate(20)->appends($request->all());
            
            // Calculate saldo from records before current page
            $currentPage = request()->get('page', 1);
            $perPage = 20;
            $skipRecords = ($currentPage - 1) * $perPage;
            
            $saldoSebelumHalaman = 0;
            if ($skipRecords > 0) {
                $recordsSebelumnya = KasKecilDet::join('tbKasKecil', 'tbKasKecil_Detail.Nomor', '=', 'tbKasKecil.Nomor')
                    ->whereBetween('tbKasKecil.Tanggal', [$request->date_start, $request->date_end])
                    ->where('tbKasKecil_Detail.Nomor', 'like', '%' . $request->coa . '%')
                    ->orderBy('tbKasKecil.Tanggal', 'asc')
                    ->limit($skipRecords)
                    ->get();
                    
                foreach ($recordsSebelumnya as $record) {
                    $saldoSebelumHalaman -= $record->Nilai1;
                }
            }
            
            // Add saldo calculation to each item
            foreach ($kasKecils as $kas) {
                $kas->saldo_sebelum_halaman = $saldoSebelumHalaman;
            }
        }

        $data = [
            'kasKecils' => $kasKecils,
            'coa' => $coa,
            'saldoKasBulanLalu' => $saldoKasBulanLalu,
            'saldoSebelumHalaman' => isset($saldoSebelumHalaman) ? $saldoSebelumHalaman : 0,
        ];

        return view('admin.acc.kas_kecil', $data);
    }

    public function export(Request $request)
    {
        // Validate required parameters
        if (empty($request->date_start) || empty($request->date_end) || empty($request->coa)) {
            return redirect()->route('acc.kaskecil')->with('error', 'Parameter filter harus diisi untuk export');
        }

        // Get COA info
        $coaRecord = COA::where('Kode_Bukti', $request->coa)->first();
        $coaName = $coaRecord ? $coaRecord->nm_coa : 'Unknown COA';

        // Get saldo awal
        $saldoKasBulanLalu = null;
        if ($coaRecord) {
            $periodeBulanLalu = Carbon::parse($request->date_start)->subMonth()->format('m/Y');
            // $nomor_coa = $coaRecord->get_nomor_coa();
            $saldoKasBulanLalu = TrialBalance::where('Periode', $periodeBulanLalu)
                ->where('KdCOA', 'like', $coaRecord->kd_coa . '%')
                ->first();
            // dd($saldoKasBulanLalu);
        }

        // Get all data without pagination
        $kasKecils = KasKecilDet::with('kasKecil')
            ->join('tbKasKecil', 'tbKasKecil_Detail.Nomor', '=', 'tbKasKecil.Nomor')
            ->whereBetween('tbKasKecil.Tanggal', [$request->date_start, $request->date_end])
            ->where('tbKasKecil_Detail.Nomor', 'like', '%' . $request->coa . '%')
            ->orderBy('tbKasKecil.Tanggal', 'asc')
            ->select('tbKasKecil_Detail.*')
            ->get();

        // Prepare export data
        $exportData = [];
        $saldoAwal = $saldoKasBulanLalu ? $saldoKasBulanLalu->SaldoAkhir : 0;
        $saldoBerjalan = $saldoAwal;

        // Add header info
        $exportData[] = ['Laporan Kas Kecil'];
        $exportData[] = ['COA: ' . $coaRecord->kd_coa . ' - ' . $coaName];
        $exportData[] = ['Periode: ' . date('d/m/Y', strtotime($request->date_start)) . ' s/d ' . date('d/m/Y', strtotime($request->date_end))];
        $exportData[] = ['Saldo Awal: Rp ' . number_format($saldoAwal, 0, ',', '.')];
        $exportData[] = []; // Empty row

        // Add table headers
        $exportData[] = [
            'No',
            'Tanggal', 
            'Nomor',
            'No. Invoice',
            'Deskripsi',
            'Debit',
            'Kredit', 
            'Saldo',
            'COA',
            'Nama COA'
        ];

        // Add data rows
        $totalDebit = 0;
        $totalKredit = 0;
        
        foreach ($kasKecils as $index => $kas) {
            $saldoBerjalan -= ($kas->Nilai1);

            $debit = ($kas->kasKecil && $kas->kasKecil->{'Jenis Transaksi'} == 'Kas Kecil Masuk') ? ($kas->Nilai1 * -1) : 0;
            $kredit = ($kas->kasKecil && $kas->kasKecil->{'Jenis Transaksi'} == 'Kas Kecil Keluar') ? $kas->Nilai1 : 0;

            // Accumulate totals
            $totalDebit += $debit;
            $totalKredit += $kredit;

            $exportData[] = [
                $index + 1,
                $kas->kasKecil && $kas->kasKecil->Tanggal ? date('d/m/Y', strtotime($kas->kasKecil->Tanggal)) : '-',
                $kas->Nomor ?? '-', 
                $kas->{'Ref No'} ?? '-',
                $kas->Description ?? '-',
                $debit,
                $kredit,
                $saldoBerjalan,
                $kas->COA ?? '-',
                ($kas->coa && $kas->coa->nm_coa) ? $kas->coa->nm_coa : '-'
            ];
        }

        // Add footer with totals
        $exportData[] = []; // Empty row
        $exportData[] = [
            '',
            '',
            '',
            '',
            'TOTAL',
            $totalDebit,
            $totalKredit,
            $saldoBerjalan,
            '',
            ''
        ];

        // Generate filename
        $filename = 'kas_kecil_' . str_replace(['/', '-'], '', $request->date_start) . '_' . str_replace(['/', '-'], '', $request->date_end) . '_' . $request->coa . '.xlsx';

        return Excel::download(new KasKecilExport($exportData), $filename);
    }
}
