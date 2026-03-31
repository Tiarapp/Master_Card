<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\COA;
use App\Models\Accounting\KasKecil;
use App\Models\Accounting\KasKecilDet;
use App\Models\Accounting\TrialBalance;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

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
}
