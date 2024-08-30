<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\fbBarang;
use App\Models\Mastercard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Tampilkan awal
     public function index()
    {

        DB::connection('firebird2')->beginTransaction();
        $periode = date("m/Y");
        $barang = DB::connection('firebird2')->table('TPersediaan')
        ->leftJoin('TBarangConv', 'TPersediaan.KodeBrg', '=', 'TBarangConv.KodeBrg')
        ->select('TPersediaan.KodeBrg', 'TBarangConv.NamaBrg', 'TPersediaan.SaldoAkhirCrt as SaldoPcs', 'TPersediaan.SaldoAkhirKg as SaldoKg', 'TPersediaan.Periode', 'TBarangConv.BeratStandart', 'TBarangConv.Satuan', 'TBarangConv.IsiPerKarton', 'TBarangConv.WeightValue')
        ->where('TPersediaan.Periode', 'LIKE', "%".$periode."%")
        // ->where('TPersediaan.Periode', 'LIKE', "%04/2020%")
        // ->where('TPersediaan.SaldoAkhirCrt', '!=', 0)
        ->orderBy('TPersediaan.KodeBrg', 'asc')->get();

        if (!$barang) {
            $periode = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
            dd($periode);
        }

        // dd($barang);

        return view('admin.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Tampilkan Halaman Input
     public function create()
    {
        DB::connection('firebird2')->beginTransaction();

        $box = DB::connection('firebird2')->table('TProdConv')->get();
        $merk = DB::connection('firebird2')->table('TMerkConv')->get();
        $joint = DB::table('joint')->get();
        $warna = DB::connection('firebird2')->table('TWarnaConv')->get();
        
        
        return view('admin.barang.create', compact([
            // 'item',
            'merk',
            'box',
            'joint',
            'warna'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        DB::connection('firebird2')->beginTransaction();
        
        $periode = date("m/Y");
        $barang = DB::connection('firebird2')->table('TBarangConv')->where('KodeBrg', '=', $request->kodeBarang)->first();
        
        if (!$barang) {
            DB::connection('firebird2')->table('TBarangConv')->insert([
                'KodeBrg' => $request->kodeBarang,
                'NamaBrg' => strtoupper($request->namaBarang),
                'Eceran' => $request->ecer,
                'Tujuan' => $request->tujuan,
                'JenisProd' => $request->tipebox,
                'Merk' => $request->flute,
                'Design' => $request->design,
                'WeightSheet' => $request->weight,
                'Packing' => $request->koli,
                'WeightValue' => $request->mcnumb,
                'Warna' => $request->rev,
                'Satuan' => $request->satuan,
                'IsiPerKarton' => $request->isi,
                'BeratStandart' => $request->berat,
                'HargaJualRp' => $request->hargajual,
                'HargaJualUSD' => $request->hargausd,
                'BeratCRT' => $request->beratcrt,
                'CustNick' => $request->golongan
            ]);

            DB::connection('firebird2')->table('TPersediaan')->insert([
                'KodeBrg' => $request->kodeBarang,
                'Periode' => $periode,
                'SaldoAwalCrt' => 0,
                'SaldoAwalKg' => 0,
                'SaldoAkhirCrt' => 0,
                'SaldoAkhirKg' => 0,
            ]);

            DB::connection('firebird2')->commit();
            return redirect('admin/barang')->with('success', "Data Berhasil disimpan dengan kode Barang = ". $request->kodeBarang);
        } else {
            return redirect()->to(url()->previous())->with('danger', "Kode Barang ini ". $barang->KodeBrg." sudah ada dengan nama = ". $barang->NamaBrg);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function getMutasi(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();
        $result = [];

        $barang = DB::connection('firebird2')->table('TBarangConv')->where('KodeBrg', '=', $request->kodebarang)->first();
        $persediaan = DB::connection('firebird2')->table('TPersediaan')->where('KodeBrg', '=', $request->kodebarang)
        ->where('TPersediaan.Periode', 'LIKE', "%".$request->periode."%")
        ->select('SaldoAwalCrt', 'Periode as period', 'SaldoAkhirCrt')
        ->first();

        $php = DB::connection('firebird2')->table('TDetPHP')
            ->leftJoin('TPHP', 'TDetPHP.NoPHP', '=', 'TPHP.NoBukti')
            ->select('TDetPHP.*', 'TPHP.Periode', 'TPHP.TglPHP', 'TPHP.Keterangan')
            ->where('TDetPHP.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
            ->where('TPHP.Periode', 'LIKE', "%".$request->periode."%")
            ->get();

        $sj = DB::connection('firebird2')->table('TDetSJ')
        ->leftJoin('TSuratJalan', 'TDetSJ.NomerSJ', '=', 'TSuratJalan.NomerSJ')
        ->select('TDetSJ.*', 'TSuratJalan.Periode', 'TSuratJalan.TglSJ', 'TSuratJalan.NamaCust', 'TSuratJalan.NoSeal as noopi')
        ->where('TDetSJ.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TSuratJalan.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        $repack = DB::connection('firebird2')->table('TDetRepack')
        ->leftJoin('TRepack', 'TDetRepack.NoRepack', '=', 'TRepack.NoRepack')
        ->select('TDetRepack.*', 'TRepack.Periode', 'TRepack.TglRepack', 'TRepack.Keterangan')
        ->where('TDetRepack.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TRepack.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        // dd($php);

        if ($php) {
            foreach ($php as $data) {
                
                $nestedData["tanggal"] = $data->TglPHP;
                $nestedData["nobukti"] = $data->NoPHP;
                $nestedData["masuk"] = $data->Quantity;
                $nestedData["keluar"] = 0;
                $nestedData["keterangan"] = $data->Keterangan;
                $nestedData["opi"] = $data->NOOPI;

                $result[] = $nestedData;
            }
        } 


        if ($sj) {
            foreach ($sj as $data) {
                $nestedData["tanggal"] = $data->TglSJ;
                $nestedData["nobukti"] = $data->NomerSJ;
                $nestedData["keluar"] = $data->Quantity;
                $nestedData["masuk"] = 0;
                $nestedData["keterangan"] = $data->NamaCust;
                $nestedData["opi"] = $data->noopi;
                
                $result[] = $nestedData;
            }
        }

        if ($repack) {
            foreach ($repack as $data) {
                $kode = explode("-", $data->NoRepack);

                if($kode[0] === "RK") {
                    $nestedData["tanggal"] = $data->TglRepack;
                    $nestedData["nobukti"] = $data->NoRepack;
                    $nestedData["masuk"] = 0;
                    $nestedData["keluar"] = $data->Quantity;
                    $nestedData["keterangan"] = $data->Keterangan;
                    $nestedData["opi"] = '';
    
                    
                $result[] = $nestedData;
                } else {
                    
                    $nestedData["tanggal"] = $data->TglRepack;
                    $nestedData["nobukti"] = $data->NoRepack;
                    $nestedData["masuk"] = $data->Quantity;
                    $nestedData["keluar"] = 0;
                    $nestedData["keterangan"] = $data->Keterangan;
                    $nestedData["opi"] = '';
                    
                $result[] = $nestedData;
                }

            }
        }

        return view('admin.barang.mutasi', compact('result', 'barang', 'persediaan'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // Tampilkan halaman Edit
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // Untuk Simpan yg sudah diedit    
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // Untuk Delete
    public function destroy(Barang $barang)
    {
        //
    }
}
