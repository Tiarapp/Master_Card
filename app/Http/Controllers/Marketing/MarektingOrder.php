<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MarektingOrder extends Controller
{
    public function index()
    {
        return view('admin.Marketing.mod');
    }

    public function getMod($tanggal)
    {
        DB::connection('firebird2')->beginTransaction();

        $mod = DB::connection('firebird2')->table('TDetMOD')
            ->leftJoin('TMOD', 'TDetMOD.NoMOD', '=', 'TMOD.NoBukti')
            ->leftJoin('TBarangConv', 'TDetMOD.KodeBrg', '=', 'TBarangConv.KodeBrg')
            ->select('TDetMOD.*', 'TMOD.TglOrder', 'TMOD.NamaCust', 'TMOD.NomerSC', 'TBarangConv.NamaBrg')
            ->where('TMOD.TglOrder', 'LIKE', $tanggal)
            ->get();

       return DataTables::of($mod)->toJson();
    }
}
