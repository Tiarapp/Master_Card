<?php

namespace App\Http\Controllers\Stellar\BP;

use App\Http\Controllers\Controller;
use App\Models\Firebird\Stellar\BP\DetBbm;
use App\Exports\BbmExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BbmController extends Controller
{
    public function index(Request $request)
    {
        DB::connection('stellar_bp')->beginTransaction(); 
        $bbm = new DetBbm();
        $bbm = $bbm->with('barang', 'master_bbm')
                ->whereHas('master_bbm', function($query) {
                    $query->where('NoBukti', 'like', 'PHP%');
                });

        // Period filtering (MM/YYYY)
        if($request->filled('period')) {
            $period = $request->input('period'); // Format: YYYY-MM
            // Split period into month and year for Firebird compatibility
            list($year, $month) = explode('-', $period);
            
            // Create first and last day of the month for date range filtering
            $startDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate)); // Last day of month
            
            $bbm = $bbm->whereHas('master_bbm', function($query) use ($startDate, $endDate) {
                $query->whereBetween('TglMasuk', [$startDate, $endDate]);
            });
        }

        if($request->filled('search')) {
            $bbm = $bbm->whereHas('barang', function($query) use ($request) {
                $query->where('NamaBrg', 'like', '%' . $request->input('search') . '%');
            })->orWhereHas('master_bbm', function($query) use ($request) {
                $query->where('NoBukti', 'like', '%' . $request->input('search') . '%');
            });
        }

        $bbm = $bbm->orderBy('NoUrut', 'desc')->paginate(20);

        $data = [
            'bbm' => $bbm
        ];
        return view('stellar.bp.bbm.index', $data);
    }

    /**
     * Export BBM data to Excel
     */
    public function export(Request $request)
    {
        $filters = [];
        
        // Include period filter if provided
        if ($request->filled('period')) {
            $filters['period'] = $request->input('period');
        }
        
        // Include search filter if provided
        if ($request->filled('search')) {
            $filters['search'] = $request->input('search');
        }
        
        // Generate filename with timestamp and filters
        $filename = 'Data_BBM_' . date('Y-m-d_H-i-s');
        
        if (!empty($filters['period'])) {
            $period = date('m-Y', strtotime($filters['period'] . '-01'));
            $filename .= '_' . $period;
        }
        
        $filename .= '.xlsx';
        
        return Excel::download(new BbmExport($filters), $filename);
    }

    
}
