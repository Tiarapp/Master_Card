<?php

namespace App\Http\Controllers;

use App\Models\PersediaanBj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                            return number_format($temp1->SaldoKg, 2);
                        })
                        ->addColumn('berat', function($temp1) {
                            return number_format($temp1->BeratStandart, 2);
                        })
                        ->addColumn('isi_karton', function($temp1) {
                            return number_format($temp1->IsiPerKarton, 0);
                        })
                        ->make(true);
            }

        return view('admin.fg.barang.index');
    }

    public function indexnew(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();
        $periode = date("m/Y");
        
        $query = DB::connection('firebird2')->table('TPersediaan')
            ->leftJoin('TBarangConv', 'TPersediaan.KodeBrg', '=', 'TBarangConv.KodeBrg')
            ->select('TPersediaan.KodeBrg', 'TBarangConv.NamaBrg', 'TPersediaan.SaldoAkhirCrt as SaldoPcs', 'TPersediaan.SaldoAkhirKg as SaldoKg', 'TPersediaan.Periode', 'TBarangConv.BeratStandart', 'TBarangConv.Satuan', 'TBarangConv.IsiPerKarton', 'TBarangConv.WeightValue')
            ->where('TPersediaan.Periode', 'LIKE', "%".$periode."%");

        // Handle search - support multiple words with OR logic
        if ($request->has('search') && !empty($request->search)) {
            $search = strtoupper(trim($request->search));
            
            // Split search into individual words
            $searchWords = explode(' ', $search);
            
            // Debug: Log the search parameters
            Log::info('Search parameters:', [
                'original_search' => $request->search,
                'processed_search' => $search,
                'search_words' => $searchWords
            ]);
            
            $query->where(function($q) use ($searchWords, $search) {
                // First, try to match the full search string
                $q->where('TPersediaan.KodeBrg', 'LIKE', '%'.$search.'%')
                  ->orWhere('TBarangConv.NamaBrg', 'LIKE', '%'.$search.'%');
                
                // Then, try to match individual words with OR logic
                foreach ($searchWords as $word) {
                    $word = trim($word);
                    if (!empty($word) && strlen($word) > 1) {
                        $q->orWhere('TPersediaan.KodeBrg', 'LIKE', '%'.$word.'%')
                          ->orWhere('TBarangConv.NamaBrg', 'LIKE', '%'.$word.'%');
                    }
                }
            });
            
            // Debug: Log the final query
            Log::info('Final query SQL:', ['query' => $query->toSql()]);
        }

        $barang = $query->orderBy('TPersediaan.KodeBrg', 'asc')->paginate(20);

        return view('admin.fg.barang.indexnew', compact('barang'));
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
        
        $query = DB::connection('firebird2')->table('TReturJual');
        
        // Handle search filter if needed
        if ($request->filled('search')) {
            $search = strtoupper(trim($request->search));
            $query->where(function($q) use ($search) {
                $q->where('NoBukti', 'LIKE', '%'.$search.'%')
                  ->orWhere('KodeCust', 'LIKE', '%'.$search.'%')
                  ->orWhere('NamaCust', 'LIKE', '%'.$search.'%');
            });
        }
        
        // Handle date filter if needed
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $query->whereBetween('TglRetur', [$request->date_start, $request->date_end]);
        }
        
        $retur = $query->orderBy('TglRetur', 'desc')->paginate(20);
        
        return view('admin.fg.barang.retur.index', compact('retur'));
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

    public function store_retur(Request $request)
    {
        dd($request->all());
        $request->validate([
            'tanggal' => 'required|date',
            'kode' => 'required',
            // 'keterangan' => 'required',
            'KodeCust' => 'required',
            'NamaCust' => 'required',
            // 'sj_details' => 'required|array|min:1',
            // 'sj_details.*.kodeBrg' => 'required',
            // 'sj_details.*.noSJ' => 'required',
            // 'sj_details.*.quantity' => 'required|integer|min:1',
            // 'sj_details.*.keterangan' => 'required'
        ]);

        try {
            DB::connection('firebird2')->beginTransaction();

            $periode = date("m/Y", strtotime($request->tanggal));
            
            // Calculate totals from SJ details
            $totalReturCrt = 0;
            $totalReturEcr = 0;
            
            foreach ($request->sj_details as $detail) {
                $totalReturCrt += $detail['quantity'];
                // You might need to calculate totalReturEcr based on price if available
            }
            
            // Insert ke TReturJual (Master)
            DB::connection('firebird2')->table('TReturJual')->insert([
                'NoBukti' => $request->kode,
                'Periode' => $periode,
                'TglRetur' => $request->tanggal,
                'KodeCust' => $request->KodeCust,
                'NamaCust' => $request->NamaCust,
                'TotReturCrt' => $totalReturCrt,
                'TotalReturEcr' => $totalReturEcr,
                'Aktif' => 'Y',
                'Print' => 0,
                'Locked' => 'N'
            ]);

            // Insert multiple detail records
            foreach ($request->sj_details as $index => $detail) {
                // Get barang details for additional info if needed
                $barangInfo = DB::connection('firebird2')->table('TBarangConv')
                    ->where('KodeBrg', $detail['kodeBrg'])
                    ->first();
                
                DB::connection('firebird2')->table('TDetReturJual')->insert([
                    'NoBukti' => $request->kode,
                    'NoUrut' => $index + 1,
                    'KodeBrg' => $detail['kodeBrg'],
                    'NamaBrg' => $barangInfo->NamaBrg ?? 'Unknown',
                    'Quantity' => $detail['quantity'],
                    'Satuan' => $barangInfo->SatuanCrt ?? 'Pcs',
                    'HargaEceran' => $barangInfo->HargaEceran ?? 0,
                    'JumlahEceran' => ($barangInfo->HargaEceran ?? 0) * $detail['quantity'],
                    'HargaKarton' => 0,
                    'JumlahKarton' => 0,
                    'NoSJ' => $detail['noSJ'], // Add NoSJ reference
                    'Keterangan' => strtoupper($detail['keterangan'])
                ]);
            }

            // Update TKeyfield untuk nomor urut selanjutnya
            $year = date('y', strtotime($request->tanggal));
            $month = date('m', strtotime($request->tanggal));
            $concat = $year . $month;
            $kode_prefix = "RA-2".$concat;

            $key = DB::connection('firebird2')->table('TKeyfield')
                        ->where('Nama', 'LIKE', $kode_prefix."%")->first();
                        
            if ($key) {
                DB::connection('firebird2')->table('TKeyfield')
                    ->where('Nama', 'LIKE', $kode_prefix.'%')
                    ->update([
                        'NoUrut' => $key->NoUrut + 1
                    ]);
            }

            DB::connection('firebird2')->commit();

            return redirect()->route('barang.retur')->with('success', 'Retur penjualan berhasil disimpan dengan nomor: ' . $request->kode . ' (' . count($request->sj_details) . ' detail barang)');

        } catch (\Exception $e) {
            DB::connection('firebird2')->rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan retur penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function getPersediaan()
    {
        DB::connection('firebird2')->beginTransaction();
        $periode = date("m/Y");
        $bulan = substr($periode, 0, 2);
        $tahun = substr($periode, 3, 4);
        $data = DB::connection('firebird2')->table('TPersediaan')
        ->whereRaw("TRIM(Periode) = ?", [$periode])
        ->take(5)->get();

        dd($data);
        
    }

    // Barang BP

    public function teknik(Request $request)
    {
        DB::connection('fbbp')->beginTransaction();
        $periode = date("m/Y");
        $barang = DB::connection('fbbp')->table('TPersediaanConv')
        ->leftJoin('TBarang', 'TPersediaanConv.KodeBrg', '=', 'TBarang.KodeBrg')
        ->select('TPersediaanConv.KodeBrg', 'TBarang.NamaBrg', 'TPersediaanConv.SaldoAkhirP as SaldoPrimer', 'TPersediaanConv.SaldoAkhirS as SaldoSekunder', 'TPersediaanConv.Periode', 'TBarang.NilaiKonversi', 'TBarang.SatuanP', 'TBarang.SatuanS')
        ->where('TPersediaanConv.Periode', 'LIKE', "%".$periode."%")
        ->orderBy('TPersediaanConv.KodeBrg', 'asc')->get();

        if ($request->ajax()) {
                return DataTables::of($barang)
                        ->addColumn('action', function($barang) {
                            return '<button type="button" class="btn btn-primary mutasi" data-toggle="modal" data-target="#exampleModalCenter" value="'.$barang->KodeBrg.'">Cek Mutasi</button>
                            
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
                                        <form action="'.route('fb.bp.mutasi').'" method="POST">'.
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
                        ->addColumn('saldo_pcs', function($barang) {
                            return number_format($barang->SaldoPrimer, 0);
                        })
                        ->addColumn('saldo_kg', function($barang) {
                            return number_format($barang->SaldoSekunder, 2);
                        })
                        ->addColumn('berat', function($barang) {
                            return number_format($barang->NilaiKonversi, 2);
                        })
                        ->make(true);
            }

        return view('admin.barangpembantu.index');
    }

    public function get_mutasi_bp(Request $request)
    {
        DB::connection('fbbp')->beginTransaction();
        $result = [];
        $supplier = [];

        $barang = DB::connection('fbbp')->table('TBarang')->where('KodeBrg', '=', $request->kodebarang)->first();
        $persediaan = DB::connection('fbbp')->table('TPersediaanConv')->where('KodeBrg', '=', $request->kodebarang)
        ->where('TPersediaanConv.Periode', 'LIKE', "%".$request->periode."%")
        ->select('SaldoAwalP', 'SaldoAwalS', 'Periode as period', 'SaldoAkhirP', 'SaldoAkhirS')
        ->first();

        $bbm = DB::connection('fbbp')->table('TDetBBMConv')
            ->leftJoin('TBBMConv', 'TDetBBMConv.NoBBM', '=', 'TBBMConv.NoBukti')
            ->leftJoin('TOPConv', 'TDetBBMConv.NoOP', '=', 'TOPConv.NoOP')
            ->select(
                'TDetBBMConv.*',
                'TBBMConv.Periode',
                'TBBMConv.TglMasuk',
                'TBBMConv.Keterangan',
                'TOPConv.KodeSupp'
            )
            ->where('TDetBBMConv.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
            ->where('TBBMConv.Periode', 'LIKE', "%".$request->periode."%")
            ->get();

        foreach ($bbm as $data) {
            $searchsupp = '';
            $searchsupp = DB::connection('firebird')->table('TSupplier')
            ->where('Kode', '=', $data->KodeSupp)->first();

            $supplier[] = $searchsupp->Nama;
        }
            
        $returbbk = DB::connection('fbbp')->table('TDetReturProd')
        ->leftJoin('TReturProd', 'TDetReturProd.NoBBK', '=', 'TReturProd.NoBukti')
        ->select('TDetReturProd.*', 'TReturProd.Periode', 'TReturProd.TglRetur', 'TReturProd.Keterangan')
        ->where('TDetReturProd.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TReturProd.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        $bbk = DB::connection('fbbp')->table('TDetBBKConv')
        ->leftJoin('TBBKConv', 'TDetBBKConv.NoBukti', '=', 'TBBKConv.NoBukti')
        ->select('TDetBBKConv.*', 'TBBKConv.Periode', 'TBBKConv.TglKeluar', 'TBBKConv.Keterangan')
        ->where('TDetBBKConv.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TBBKConv.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        $returbbm = DB::connection('fbbp')->table('TDetReturBBM')
        ->leftJoin('TReturBBM', 'TDetReturBBM.NoRetur', '=', 'TReturBBM.NoBukti')
        ->select('TDetReturBBM.*', 'TReturBBM.Periode', 'TReturBBM.TglRetur', 'TReturBBM.Keterangan', 'TReturBBM.KodeSupp')
        ->where('TDetReturBBM.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TReturBBM.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        // dd($php);

        if ($bbm) {
            foreach ($bbm as $data) {

                $searchsupp = DB::connection('firebird')->table('TSupplier')
                    ->where('Kode', '=', $data->KodeSupp)->first();
                
                $nestedData["tanggal"] = $data->TglMasuk;
                $nestedData["nobukti"] = $data->NoBBM;
                $nestedData["masukp"] =$data->QtyP;
                $nestedData["masuks"] =$data->QtyS;
                $nestedData["keluarp"] = 0;
                $nestedData["keluars"] = 0;
                $nestedData["keterangan"] = trim($data->Keterangan). " - ".$searchsupp->Nama;

                $result[] = $nestedData;
            }
        }

        if ($returbbk) {
            foreach ($returbbk as $data) {
                
                $nestedData["tanggal"] = $data->TglRetur;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["masukp"] =$data->QtyP;
                $nestedData["masuks"] =$data->QtyS;
                $nestedData["keluarp"] = 0;
                $nestedData["keluars"] = 0;
                $nestedData["keterangan"] = $data->Keterangan." - ".$data->NoBBK;

                $result[] = $nestedData;
            }
        } 


        if ($bbk) {
            foreach ($bbk as $data) {
                $nestedData["tanggal"] = $data->TglKeluar;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["keluarp"] = $data->QtyP;
                $nestedData["keluars"] = $data->QtyS;
                $nestedData["masukp"] = 0;
                $nestedData["masuks"] = 0;
                $nestedData["keterangan"] = $data->Keperluan ." - ". $data->Keterangan;
                
                $result[] = $nestedData;
            }
        }

        if ($returbbm) {
            foreach ($returbbm as $data) {
                $searchsupp = DB::connection('firebird')->table('TSupplier')
                    ->where('Kode', '=', $data->KodeSupp)->first();

                    $nestedData["tanggal"] = $data->TglRetur;
                    $nestedData["nobukti"] = $data->NoBukti;
                    $nestedData["masukp"] = 0;
                    $nestedData["masuks"] = 0;
                    $nestedData["keluarp"] =$data->QtyP;
                    $nestedData["keluars"] =$data->QtyS;
                    $nestedData["keterangan"] = $data->Keterangan." - ".$searchsupp->Nama ." - ".$data->NoBBM;
    
                    
                $result[] = $nestedData;

            }
        }

        return view('admin.barangpembantu.mutasi', compact('result', 'barang', 'persediaan'));

    }

    public function bp_lama(Request $request)
    {
        DB::connection('fbbp-lama')->beginTransaction();
        $periode = "07/2025";
        $barang = DB::connection('fbbp-lama')->table('TPersediaanConv')
        ->leftJoin('TBarang', 'TPersediaanConv.KodeBrg', '=', 'TBarang.KodeBrg')
        ->select('TPersediaanConv.KodeBrg', 'TBarang.NamaBrg', 'TPersediaanConv.SaldoAkhirP as SaldoPrimer', 'TPersediaanConv.SaldoAkhirS as SaldoSekunder', 'TPersediaanConv.Periode', 'TBarang.NilaiKonversi', 'TBarang.SatuanP', 'TBarang.SatuanS')
        ->where('TPersediaanConv.Periode', 'LIKE', "%".$periode."%")
        ->orderBy('TPersediaanConv.KodeBrg', 'asc')->get();

        if ($request->ajax()) {
                return DataTables::of($barang)
                        ->addColumn('action', function($barang) {
                            return '<button type="button" class="btn btn-primary mutasi" data-toggle="modal" data-target="#exampleModalCenter" value="'.$barang->KodeBrg.'">Cek Mutasi</button>
                            
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
                                        <form action="'.route('fb.bp_lama.mutasi').'" method="POST">'.
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
                        ->addColumn('saldo_pcs', function($barang) {
                            return number_format($barang->SaldoPrimer, 0);
                        })
                        ->addColumn('saldo_kg', function($barang) {
                            return number_format($barang->SaldoSekunder, 2);
                        })
                        ->addColumn('berat', function($barang) {
                            return number_format($barang->NilaiKonversi, 2);
                        })
                        ->make(true);
            }

        return view('admin.barangpembantu.indexlama');
    }

    public function get_mutasi_bp_lama(Request $request)
    {
        DB::connection('fbbp-lama')->beginTransaction();
        $result = [];
        $supplier = [];

        $barang = DB::connection('fbbp-lama')->table('TBarang')->where('KodeBrg', '=', $request->kodebarang)->first();
        $persediaan = DB::connection('fbbp-lama')->table('TPersediaanConv')->where('KodeBrg', '=', $request->kodebarang)
        ->where('TPersediaanConv.Periode', 'LIKE', "%".$request->periode."%")
        ->select('SaldoAwalP', 'SaldoAwalS', 'Periode as period', 'SaldoAkhirP', 'SaldoAkhirS')
        ->first();

        $bbm = DB::connection('fbbp-lama')->table('TDetBBMConv')
            ->leftJoin('TBBMConv', 'TDetBBMConv.NoBBM', '=', 'TBBMConv.NoBukti')
            ->leftJoin('TOPConv', 'TDetBBMConv.NoOP', '=', 'TOPConv.NoOP')
            ->select(
                'TDetBBMConv.*',
                'TBBMConv.Periode',
                'TBBMConv.TglMasuk',
                'TBBMConv.Keterangan',
                'TOPConv.KodeSupp'
            )
            ->where('TDetBBMConv.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
            ->where('TBBMConv.Periode', 'LIKE', "%".$request->periode."%")
            ->get();

        foreach ($bbm as $data) {
            $searchsupp = '';
            $searchsupp = DB::connection('firebird')->table('TSupplier')
            ->where('Kode', '=', $data->KodeSupp)->first();

            $supplier[] = $searchsupp->Nama;
        }
            
        $returbbk = DB::connection('fbbp-lama')->table('TDetReturProd')
        ->leftJoin('TReturProd', 'TDetReturProd.NoBBK', '=', 'TReturProd.NoBukti')
        ->select('TDetReturProd.*', 'TReturProd.Periode', 'TReturProd.TglRetur', 'TReturProd.Keterangan')
        ->where('TDetReturProd.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TReturProd.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        $bbk = DB::connection('fbbp-lama')->table('TDetBBKConv')
        ->leftJoin('TBBKConv', 'TDetBBKConv.NoBukti', '=', 'TBBKConv.NoBukti')
        ->select('TDetBBKConv.*', 'TBBKConv.Periode', 'TBBKConv.TglKeluar', 'TBBKConv.Keterangan')
        ->where('TDetBBKConv.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TBBKConv.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        $returbbm = DB::connection('fbbp-lama')->table('TDetReturBBM')
        ->leftJoin('TReturBBM', 'TDetReturBBM.NoRetur', '=', 'TReturBBM.NoBukti')
        ->select('TDetReturBBM.*', 'TReturBBM.Periode', 'TReturBBM.TglRetur', 'TReturBBM.Keterangan', 'TReturBBM.KodeSupp')
        ->where('TDetReturBBM.KodeBrg', 'LIKE', "%".$request->kodebarang."%")
        ->where('TReturBBM.Periode', 'LIKE', "%".$request->periode."%")
        ->get();

        // dd($php);

        if ($bbm) {
            foreach ($bbm as $data) {

                $searchsupp = DB::connection('firebird')->table('TSupplier')
                    ->where('Kode', '=', $data->KodeSupp)->first();
                
                $nestedData["tanggal"] = $data->TglMasuk;
                $nestedData["nobukti"] = $data->NoBBM;
                $nestedData["masukp"] =$data->QtyP;
                $nestedData["masuks"] =$data->QtyS;
                $nestedData["keluarp"] = 0;
                $nestedData["keluars"] = 0;
                $nestedData["keterangan"] = trim($data->Keterangan). " - ".$searchsupp->Nama;

                $result[] = $nestedData;
            }
        }

        if ($returbbk) {
            foreach ($returbbk as $data) {
                
                $nestedData["tanggal"] = $data->TglRetur;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["masukp"] =$data->QtyP;
                $nestedData["masuks"] =$data->QtyS;
                $nestedData["keluarp"] = 0;
                $nestedData["keluars"] = 0;
                $nestedData["keterangan"] = $data->Keterangan." - ".$data->NoBBK;

                $result[] = $nestedData;
            }
        } 


        if ($bbk) {
            foreach ($bbk as $data) {
                $nestedData["tanggal"] = $data->TglKeluar;
                $nestedData["nobukti"] = $data->NoBukti;
                $nestedData["keluarp"] = $data->QtyP;
                $nestedData["keluars"] = $data->QtyS;
                $nestedData["masukp"] = 0;
                $nestedData["masuks"] = 0;
                $nestedData["keterangan"] = $data->Keperluan ." - ". $data->Keterangan;
                
                $result[] = $nestedData;
            }
        }

        if ($returbbm) {
            foreach ($returbbm as $data) {
                $searchsupp = DB::connection('firebird')->table('TSupplier')
                    ->where('Kode', '=', $data->KodeSupp)->first();

                    $nestedData["tanggal"] = $data->TglRetur;
                    $nestedData["nobukti"] = $data->NoBukti;
                    $nestedData["masukp"] = 0;
                    $nestedData["masuks"] = 0;
                    $nestedData["keluarp"] =$data->QtyP;
                    $nestedData["keluars"] =$data->QtyS;
                    $nestedData["keterangan"] = $data->Keterangan." - ".$searchsupp->Nama ." - ".$data->NoBBM;
    
                    
                $result[] = $nestedData;

            }
        }

        return view('admin.barangpembantu.mutasilama', compact('result', 'barang', 'persediaan'));

    }

    public function get_sj($sj)
    {
        try {
            // Start transaction for Firebird
            DB::connection('firebird2')->beginTransaction();
            
            // Test basic connection first
            $connectionTest = DB::connection('firebird2')->table('TSuratJalan')->limit(1)->get();
            
            $data = DB::connection('firebird2')->table('TDetSJ')
                    ->where('TDetSJ.NomerSJ', '=', $sj)
                    ->leftJoin('TSuratJalan', 'TDetSJ.NomerSJ', '=', 'TSuratJalan.NomerSJ')
                    ->leftJoin('TBarangConv', 'TDetSJ.KodeBrg', '=', 'TBarangConv.KodeBrg')
                    ->select('TDetSJ.KodeBrg', 'TBarangConv.NamaBrg', 'TDetSJ.Quantity', 'TDetSJ.NomerSJ', 'TDetSJ.NoUrut', 'TDetSJ.ReffNoUrut')
                    ->get();

            // Commit transaction
            DB::connection('firebird2')->commit();

            if ($data && $data->count() > 0) {
                $result = [];
                foreach ($data as $item) {
                    $result[] = [
                        'KodeBrg' => $item->KodeBrg,
                        'NamaBrg' => $item->NamaBrg ?? 'Nama barang tidak ditemukan',
                        'Quantity' => number_format($item->Quantity, '0', ',', ''),
                        'NoUrut' => $item->NoUrut,
                        'ReffNoUrut' => $item->ReffNoUrut,
                        'NomerSJ' => $item->NomerSJ
                    ];
                }
                return response()->json($result);
            } else {
                // Return debugging info if no data found
                return response()->json([
                    'message' => 'No data found for SJ: ' . $sj,
                    'connection_test' => $connectionTest->count() . ' records in TSuratJalan table'
                ]);
            }
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::connection('firebird2')->rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
