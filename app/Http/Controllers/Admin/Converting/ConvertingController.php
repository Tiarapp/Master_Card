<?php

namespace App\Http\Controllers\Admin\Converting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ConvertingController extends Controller
{
    public function get_sheet(Request $request)
    {
        DB::connection('fbbp')->beginTransaction();  
        $periode = date("m/Y");
        
        if ($request->ajax()) {
            $sheet = DB::connection('fbbp')->table('TPersediaanConv')
                ->leftJoin('TBarang', 'TPersediaanConv.KodeBrg', 'TBarang.KodeBrg')
                ->where('Periode', 'LIKE', $periode.'%')
                ->where(function ($query) {
                    $query->where('TPersediaanConv.KodeBrg', 'like', '11.18.%')
                    ->orWhere('TPersediaanConv.KodeBrg', 'like', '11.19.%')
                    ->orWhere('TPersediaanConv.KodeBrg', 'like', '12.19.%');
                })
                ->select('TPersediaanConv.KodeBrg as kode', 'TBarang.NamaBrg', 'TBarang.SatuanP', 'TBarang.SatuanS', 'TBarang.NilaiKonversi', 'TPersediaanConv.SaldoAkhirP', 'TPersediaanConv.SaldoAkhirS')
                ->get();
            
            return DataTables::of($sheet)
                ->addColumn('berat', function($sheet) {
                    return round($sheet->NilaiKonversi,2);
                })
                ->addColumn('stokp', function($sheet) {
                    return round($sheet->SaldoAkhirP,2);
                })
                ->addColumn('stoks', function($sheet) {
                    return round($sheet->SaldoAkhirS,2);
                })
                ->make(true);
        }
    }

    public function index_sheet()
    {
        return view('admin.sheet.index');
    }

    public function create()
    {
        DB::connection('fbbp')->beginTransaction();

        $jenis = DB::connection('fbbp')->table('TJENIS')->get();
        $jprod = DB::connection('fbbp')->table('TJenisProd')->get();
        $kelbarang = DB::connection('fbbp')->table('TKelompokBrg')->get();

        return view('admin.sheet.create', compact('jenis', 'jprod', 'kelbarang'));
    }
}
