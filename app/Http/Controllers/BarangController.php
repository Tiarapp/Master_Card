<?php

namespace App\Http\Controllers;

use App\Models\PersediaanBj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Tampilkan awal
     public function index(Request $request)
    {

        DB::connection('firebird2')->beginTransaction();
        $periode = date("m/Y");
        // $periode1 = date('m/Y', strtotime(date('Y-m')." -1 month"));
        
        $temp1 = DB::connection('firebird2')->table('TPersediaan')
        ->leftJoin('TBarangConv', 'TPersediaan.KodeBrg', '=', 'TBarangConv.KodeBrg')
        ->select('TPersediaan.KodeBrg', 'TBarangConv.NamaBrg', 'TPersediaan.SaldoAkhirCrt as SaldoPcs', 'TPersediaan.SaldoAkhirKg as SaldoKg', 'TPersediaan.Periode', 'TBarangConv.BeratStandart', 'TBarangConv.Satuan', 'TBarangConv.IsiPerKarton', 'TBarangConv.WeightValue')
        ->where('TPersediaan.Periode', 'LIKE', "%".$periode."%")
        // ->where('TPersediaan.Periode', 'LIKE', "%04/2020%")
        // ->where('TPersediaan.SaldoAkhirCrt', '!=', 0)
        ->orderBy('TPersediaan.KodeBrg', 'asc')->get();
        // {
            if ($request->ajax()) {
                return DataTables::of($temp1)
                        ->addColumn('action', function($temp1) {
                            return '<button type="button" class="btn btn-primary mutasi" data-toggle="modal" data-target="#exampleModalCenter" value="'.$temp1->KodeBrg.'">Cek Mutasi</button>
                            
                            <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="'.route('barang.mutasi').'" method="POST">'.
                                        csrf_field().'
                                        <div class="modal-body">
                                            <label for="">Periode</label>
                                            <input type="text" name="periode" id="periode" >
                                            <input type="hidden" name="kodebarang" id="kodebarang">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>';
                        })
                        ->addColumn('saldo_pcs', function($temp1) {
                            return number_format($temp1->SaldoPcs, 0);
                        })
                        ->addColumn('saldo_kg', function($temp1) {
                            return number_format($temp1->SaldoKg, 0);
                        })
                        ->addColumn('berat', function($temp1) {
                            return number_format($temp1->BeratStandart, 0);
                        })
                        ->addColumn('isi_karton', function($temp1) {
                            return number_format($temp1->IsiPerKarton, 0);
                        })
                        ->make(true);
            }

        return view('admin.fg.barang.index');
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

        $box = DB::connection('firebird2')->table('TProdConv')->orderBy('Kode','Asc')->get();
        $merk = DB::connection('firebird2')->table('TMerkConv')->orderBy('Kode','Asc')->get();
        $joint = DB::table('joint')->get();
        $warna = DB::connection('firebird2')->table('TWarnaConv')->get();
        
        
        return view('admin.fg.barang.create', compact([
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
            
        $bbm = DB::connection('firebird2')->table('TDetBBMLuar')
        ->leftJoin('TBBMLuar', 'TDetBBMLuar.NoBBM', '=', 'TBBMLuar.NoBukti')
        ->select('TDetBBMLuar.*', 'TBBMLuar.Periode', 'TBBMLuar.TglBBM', 'TBBMLuar.NamaSupp')
        ->where('TDetBBMLuar.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TBBMLuar.Periode', 'LIKE', "%".$request->periode."%")
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

        if ($bbm) {
            foreach ($bbm as $data) {
                
                $nestedData["tanggal"] = $data->TglBBM;
                $nestedData["nobukti"] = $data->NoBBM;
                $nestedData["masuk"] = $data->Quantity;
                $nestedData["keluar"] = 0;
                $nestedData["keterangan"] = $data->NamaSupp." - ".$data->NomerPO;
                $nestedData["opi"] = '';

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

        return view('admin.fg.barang.mutasi', compact('result', 'barang', 'persediaan'));

    }

    public function get_barang($kode)
    {
        DB::connection('firebird2')->beginTransaction();

        $barang = DB::connection('firebird2')->table('TBarangConv')
                ->where('KodeBrg', 'LIKE', $kode.'%')
                ->first();

        if ($barang) {
            $data = [
                'nama' => $barang->NamaBrg
            ];
        }

        return response()->json($data);
    }

    public function returjual(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();

        if ($request->ajax()) {
            $retur = DB::connection('firebird2')->table('TReturJual')
                ->get();

            return DataTables::of($retur)
                ->make(true);
        }

        return view('admin.fg.barang.retur.index');
    }

    public function create_retur()
    {
        DB::connection('firebird')->beginTransaction();
        $cust = DB::connection('firebird')->table('TCustomer')->get();

        return view('admin.fg.barang.retur.create', compact('cust'));
    }

    public function get_kode_retur($tanggal)
    {
        DB::connection('firebird2')->beginTransaction();


        $year = date('y', strtotime($tanggal));
        $month = date('m', strtotime($tanggal));

        $concat = $year . $month;
        $kode = "RA-2".$concat;

        $key = DB::connection('firebird2')->table('TKeyfield')
                    ->where('Nama', 'LIKE', $kode."%")->first();
        if ($key) {
            $nurut = str_pad($key->NoUrut + 1, 3, '0', STR_PAD_LEFT);
        } else {
            DB::connection('firebird2')->table('TKeyfield')->insert([
                'Nama' => $kode,
                'NoUrut' => 0
            ]);
            
                DB::connection('firebird2')->commit();
            $nurut = str_pad(1, 3, '0', STR_PAD_LEFT);
        }

        $no_bukti = $kode . $nurut;
        $data = [
            'kode' => $no_bukti
        ];
        
        return response()->json($data);
    }

    public function getPersediaan()
    {
        DB::connection('firebird2')->beginTransaction();
        $periode = date("m/Y");
        $persediaan = PersediaanBj::with('barang')
            ->where('Periode', 'LIKE', "%".$periode."%")
            ->get();
        
        dd($persediaan);
        
    }
}
