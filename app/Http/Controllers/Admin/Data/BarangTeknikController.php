<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BarangTeknikController extends Controller
{
    public function getBarang()
    {
        DB::connection('fbteknik')->beginTransaction();

        $periode = date("m/Y");
        $persediaan = DB::connection('fbteknik')->table('TPersediaanTK')
            ->leftJoin('TBarang', 'TPersediaanTK.KodeBrg', 'TBarang.KodeBrg')
            ->select('TPersediaanTK.KodeBrg', 'TBarang.NamaBrg', 'TBarang.Merk', 'TBarang.Tipe','TBarang.Spesifikasi', 'TPersediaanTK.SaldoAkhir', 'TPersediaanTK.Periode')
            ->where('TPersediaanTK.Periode', 'LIKE', "%".$periode."%")
            ->where('TPersediaanTK.SaldoAkhir', '>', 0);
            
        return DataTables::of($persediaan)->toJson();
    }

    public function listBarang()
    {
        return view('admin.fb.listTeknik');
    }
}
