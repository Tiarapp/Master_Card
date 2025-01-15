<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Imports\JurnalImport;
use App\Models\Accounting\Piutang;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Yajra\DataTables\DataTables;

class FinanceController extends Controller
{
    public function index()
    {
        // dd(Piutang::get());
        return view('admin.acc.import_ju');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $import = new JurnalImport();

        Excel::import($import, $file);

        return back()->with('success', 'File imported successfully!');
    }

    public function index_faktur(Request $request)
    {
        return view('admin.acc.data_faktur');
    }

    public function get_faktur(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();

        
        if ($request->periode !== '') {
            $faktur = DB::connection('firebird2')->table('TFakturConv')
            ->leftJoin('TSuratJalan as a', 'a.NomerSJ', '=', 'TFakturConv.NomerSJ')
            ->where('TFakturConv.Periode', 'LIKE', $request->periode.'%')
            ->select('NoFaktur', 'TFakturConv.NoFakturPajak', 'NoKwitansi', 'TFakturConv.NomerSJ', 'a.TglSJ', 'a.NamaCust', 'TotalTagihan')
            ->get();
            
            return DataTables::of($faktur)
                ->addColumn('action', function($faktur) {
                    return "<button><a href='../finance/faktur/print/" .trim($faktur->NomerSJ). "' title='SHOW' ><span class='glyphicon glyphicon-list'>Print</span></a></button>";
                })
                ->addColumn('total', function($faktur){ 
                    return number_format(round($faktur->TotalTagihan, 2), 2, ',', '.');
                })
                ->make(true);
        }
        
    }

    public function print_faktur($kode)
    {
        return view('admin.acc.print_faktur');
    }
}
