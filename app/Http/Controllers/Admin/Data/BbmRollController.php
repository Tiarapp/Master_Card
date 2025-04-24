<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class BbmRollController extends Controller
{
    public function getPurchaseOrderBySupp($supp)
    {
        DB::connection('fbbp')->beginTransaction();
        
        $detPO = DB::connection("fbbp")->table("TDetOPConv")
            ->leftJoin('TBarang', 'TDetOPConv.KodeBrg', 'TBarang.KodeBrg')
            ->leftJoin('TOPConv', 'TDetOPConv.NoOP', 'TOPConv.NoOP')
            ->select('TDetOPConv.*', 'TBarang.NamaBrg as barang', 'TOPConv.KodeSupp')
            ->where("TOPConv.KodeSupp", "LIKE", trim($supp)."%")
            ->where('OutStandOP', '>', 0)
            ->where(function ($query) {
                $query->whereBetween('TDetOPConv.KodeBrg', ["11.11.%", "11.17.%"])
                ->orwhereBetween('TDetOPConv.KodeBrg', ["12.11.%", "12.17.%"]);
            })
            ->orderBy("NoOP", "desc");

        return DataTables::of($detPO)
            ->only([
                'NoUrut',
                'NoOP',
                'NoOPB',
                'KodeBrg',
                'barang',
                'HargaReal'
            ])
            ->smart(true)
            ->toJson();
    }

    public function getDetPoById($id)
    {
        DB::connection('fbbp')->beginTransaction();
        
        $detPO = DB::connection("fbbp")->table("TDetOPConv")
            ->leftJoin('TBarang', 'TDetOPConv.KodeBrg', 'TBarang.KodeBrg')
            ->leftJoin('TOPConv', 'TDetOPConv.NoOP', 'TOPConv.NoOP')
            ->select('TDetOPConv.*', 'TBarang.NamaBrg as barang', 'TOPConv.KodeSupp')
            ->where("NoUrut", "LIKE", $id)
            ->orderBy("NoOP", "desc");

        return DataTables::of($detPO)
            ->only([
                'NoUrut',
                'NoOP',
                'NoOPB',
                'KodeBrg',
                'barang',
                'HargaReal'
            ])
            ->smart(true)
            ->toJson();
    }

    public function getPurchaseOrderAll()
    {
        DB::connection('fbbp')->beginTransaction();

        $detPO = DB::connection("fbbp")->table("TDetOPConv")
        ->leftJoin('TBarang', 'TDetOPConv.KodeBrg', 'TBarang.KodeBrg')
        ->leftJoin('TOPConv', 'TDetOPConv.NoOP', '=', 'TOPConv.NoOP')
        ->select('TDetOPConv.*', 'TBarang.NamaBrg', 'TOPConv.KodeSupp')
        ->where('OutStandOP', '>', 0)
        ->where(function ($query) {
            $query->whereBetween('TDetOPConv.KodeBrg', ["11.11.%", "11.17.%"])
            ->orwhereBetween('TDetOPConv.KodeBrg', ["12.11.%", "12.17.%"]);
        });
        
        return DataTables::of($detPO)
        ->only([
            'NoOP',
            'NoOPB',
            'KodeBrg',
            'NamaBrg',
            'HargaReal'
        ])
        // ->setTotalRecords(100)
        ->smart(true)
        ->toJson();
    }

    public function getBBM()
    {
        DB::connection('fbbp')->beginTransaction();

        $supp = DB::connection('firebird')->table("TSupplier")->get();
        $periode = date("m/Y");

        $bbm = DB::connection('fbbp')->table('TBBMConv')
            ->where('Periode', "LIKE", $periode."%")
            ->where('NoBukti', 'LIKE', "PBM%")
            ->orderBy('NoBukti', 'asc')
            ->get();
                
        return view('admin.fb.listBbmBp', compact('bbm'));
    }

    public function getSupp() 
    {
        DB::connection('fbbp')->beginTransaction();
        
        $supp = DB::connection('firebird')->table('TSupplier')->get();

        return DataTables::of($supp)->smart(true)->toJson();
    }

    public function add() 
    {
        DB::connection('fbbp')->beginTransaction();
        $periode = date("m/Y");

        $key = DB::connection('fbbp')->table('TKeyfield')
            ->where('Nama', 'LIKE', "PBM".$periode."%")
            ->first();
        
        $nobukti = "PBM2".date("ym").str_pad($key->NoUrut, 3, '0', STR_PAD_LEFT);

        $detPO = DB::connection("fbbp")->table("TDetOPConv")
            ->leftJoin('TBarang', 'TDetOPConv.KodeBrg', 'TBarang.KodeBrg')
            ->select('TDetOPConv.*', 'TBarang.NamaBrg')
            ->where('OutStandOP', '>', 0)
            ->where(function ($query) {
                $query->whereBetween('TDetOPConv.KodeBrg', ["11.11.%", "11.17.%"])
                ->orwhereBetween('TDetOPConv.KodeBrg', ["12.11.%", "12.17.%"]);
            })
            ->get();
        
        return view('admin.fb.add', compact('nobukti', 'detPO'));

    }

    public function simpan_bbm(Request $request) 
    {
        // dd($request->all());
        DB::connection('fbbp')->beginTransaction();

        $kodebarang = array_unique($request->kodebrg);

        $data[] = '' ;

        dd($request->kodebrg);

        DB::connection('fbbp')->table('TBBMConv')->insert([
            'NoBukti' => $request->nobukti,
            'Periode' => $request->periode,
            'TglMasuk' => $request->tanggal_masuk,
            'KodeSupp' => $request->kode_supp,
            'TglJT' => $request->tgl_jatuh_tempo,
            'JenisBBM' => "BBM",
            'Keterangan' => $request->keterangan
        ]);
    }
}
