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
        DB::connection('fbteknik')->beginTransaction();

        $periode = date("m/Y");
        $persediaan = DB::connection('fbteknik')->table('TPersediaanTK')
            ->leftJoin('TBarang', 'TPersediaanTK.KodeBrg', 'TBarang.KodeBrg')
            ->select('TPersediaanTK.KodeBrg', 'TBarang.NamaBrg', 'TBarang.Merk', 'TBarang.Tipe','TBarang.Spesifikasi', 'TPersediaanTK.SaldoAkhir', 'TPersediaanTK.Periode')
            ->where('TPersediaanTK.Periode', 'LIKE', "%".$periode."%")
            ->where('TPersediaanTK.SaldoAkhir', '>', 0)
            ->get();

            // dd($persediaan);

        return view('admin.fb.listTeknik', compact('persediaan'));
    }

    public function getMutasi(Request $request)
    {
        DB::connection('fbteknik')->beginTransaction();
        $result = [];

        $barang = DB::connection('fbteknik')->table('TBarang')->where('KodeBrg', '=', $request->kodebarang)->first();
        $persediaan = DB::connection('fbteknik')->table('TPersediaanTK')->where('KodeBrg', '=', $request->kodebarang)
        ->where('TPersediaanTK.Periode', 'LIKE', "%".$request->periode."%")
        ->select('SaldoAwal', 'Periode as period', 'SaldoAkhir')
        ->first();

        $bbm = DB::connection('fbteknik')->table('TDetBBMTK')
            ->leftJoin('TBBMTK', 'TDetBBMTK.NoBukti', '=', 'TBBMTK.NoBukti')
            ->select('TDetBBMTK.*', 'TBBMTK.Periode', 'TBBMTK.TglMasuk', 'TBBMTK.NamaSupp')
            ->where('TDetBBMTK.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
            // ->where('TBBMTK.Periode', 'LIKE', "%".$request->periode."%")
            ->get();

        $bbk = DB::connection('fbteknik')->table('TDetBBKTK')
        ->leftJoin('TBBKTK', 'TDetBBKTK.NoBukti', '=', 'TBBKTK.NoBukti')
        ->select('TDetBBKTK.*', 'TBBKTK.Periode', 'TBBKTK.TglKeluar', 'TBBKTK.Keterangan', 'TBBKTK.Peminta')
        ->where('TDetBBKTK.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        // ->where('TBBKTK.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        // dd($bbk);

        $returbbm = DB::connection('fbteknik')->table('TDetReturBBM')
            ->leftJoin('TReturBBM', 'TDetReturBBM.NoBukti', '=', 'TReturBBM.NoBukti')
            ->select('TDetReturBBM.*', 'TReturBBM.TglRetur', 'TReturBBM.NamaSupp', 'TReturBBM.Keterangan')
            ->where('TDetReturBBM.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
            // ->where('TReturBBM.Periode', 'LIKE', "%".$request->periode."%")
            ->get();

            
        $returbbk = DB::connection('fbteknik')->table('TDetReturBBK')
        ->leftJoin('TReturBBK', 'TDetReturBBK.NoBukti', '=', 'TReturBBK.NoBukti')
        ->select('TDetReturBBK.*', 'TReturBBK.TglRetur', 'TReturBBK.Keterangan')
        ->where('TDetReturBBK.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        // ->where('TReturBBK.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        $adjust = DB::connection('fbteknik')->table('TDetPenyTK')
        ->leftJoin('TPenyTK', 'TDetPenyTK.NoBukti', '=', 'TPenyTK.NoSesuai')
        ->select('TDetPenyTK.*', 'TPenyTK.Periode', 'TPenyTK.TglSesuai', 'TPenyTK.Keterangan')
        ->where('TDetPenyTK.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        // ->where('TPenyTK.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        if ($bbm) {
            foreach ($bbm as $data) {
                
                $nestedData["tanggal"] = $data->TglMasuk;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["jenis"] = "Pembelian";
                $nestedData["masuk"] = $data->QtyS;
                $nestedData["keluar"] = 0;
                $nestedData["harga"] = $data->HargaRp;
                $nestedData["keterangan"] = $data->NamaSupp;

                $result[] = $nestedData;
            }
        } 

        if ($returbbm) {
            foreach ($returbbm as $data) {
                
                $nestedData["tanggal"] = $data->TglRetur;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["jenis"] = "Retur Pembelian";
                $nestedData["keluar"] = $data->QtyS;
                $nestedData["masuk"] = 0;
                $nestedData["harga"] = $data->HargaRp;
                $nestedData["keterangan"] = $data->NamaSupp ." keterangan : ". $data->Keterangan;

                $result[] = $nestedData;
            }
        } 

        if ($returbbk) {
            foreach ($returbbk as $data) {
                
                $nestedData["tanggal"] = $data->TglRetur;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["jenis"] = "Retur Pemakaian";
                $nestedData["masuk"] = $data->QtyS;
                $nestedData["keluar"] = 0;
                $nestedData["harga"] = $data->HargaRp;
                $nestedData["keterangan"] = $data->Keterangan;

                $result[] = $nestedData;
            }
        } 


        if ($bbk) {
            foreach ($bbk as $data) {
                $nestedData["tanggal"] = $data->TglKeluar;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["jenis"] = "Pemakaian";
                $nestedData["keluar"] = $data->QtyS;
                $nestedData["masuk"] = 0;
                $nestedData["harga"] = $data->HargaRp;
                $nestedData["keterangan"] = $data->Peminta ."-". $data->Keterangan;
                
                $result[] = $nestedData;
            }
        }

        if ($adjust) {
            foreach ($adjust as $data) {
                $kode = substr($data->NoBukti, 0, 2);

                if($kode[0] === "CRT") {
                    $nestedData["tanggal"] = $data->TglSesuai;
                    $nestedData["nobukti"] = $data->NoBukti;
                    $nestedData["masuk"] = 0;
                    $nestedData["keluar"] = $data->QtyS;
                    $nestedData["harga"] = $data->HargaRp;
                    $nestedData["keterangan"] = $data->Keterangan;
    
                    
                $result[] = $nestedData;
                } else {
                    
                    $nestedData["tanggal"] = $data->TglSesuai;
                    $nestedData["nobukti"] = $data->NoBukti;
                    $nestedData["masuk"] = $data->QtyS;
                    $nestedData["keluar"] = 0;
                    $nestedData["harga"] = $data->HargaRp;
                    $nestedData["keterangan"] = $data->Keterangan;
                    
                $result[] = $nestedData;
                }

            }
        }
        
        return view('admin.fb.mutasi', compact('result', 'barang', 'persediaan'));
    }
}
