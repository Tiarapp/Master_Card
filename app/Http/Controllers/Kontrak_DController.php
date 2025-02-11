<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Mastercard;
use App\Models\Navbar\Notification;
use App\Models\Opi_M;
use App\Models\RealisasiKirim;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class Kontrak_DController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    
    // public function json()
    // {
        //     return Datatables::ofn(Kontrak_M::all())->make(true);
        // }
        
        
        public function json(Request $request)
        {
            $columns = [
                1=>'id',
                2=>'action',
                3=>'kode',
                4=>'tglKontrak',
                5=>'cust',
                6=>'alamatKirim',
            ];
            
            $totalData = Kontrak_M::count();
            $kontrak= Kontrak_M::get();
            // $kontrak = Kontrak_M::all();
            
            // dd($kontrak);
            
            $totalData = Kontrak_M::count();
            $limit = $request->input('length');
            $start = $request->input('start');
            
            // dd($start);
            
            if(empty($request->input('search.value')))
            {            
                $kontrak = Kontrak_M::offset($start)
                ->limit(50)
                ->orderBy('id', 'desc')
                ->get();
                
                $totalFiltered = Kontrak_M::count();
                // dd($opi);
            }
            else {
                $search = $request->input('search.value'); 
                
                $kontrak =  Kontrak_M::where('customer_name','LIKE',"%{$search}%")
                ->orWhere('kode', 'LIKE',"%{$search}%")
                ->orWhere('poCustomer', 'LIKE',"%{$search}%")
                ->orWhere('tipeOrder', 'LIKE',"%{$search}%")
                ->orWhere('sales', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit(50)
                ->orderBy('id', 'desc')
                ->get();
                
                $totalFiltered = Kontrak_M::where('kode','LIKE',"%{$search}%")
                ->orWhere('customer_name', 'LIKE',"%{$search}%")
                ->orWhere('poCustomer', 'LIKE',"%{$search}%")
                ->orWhere('tipeOrder', 'LIKE',"%{$search}%")
                ->orWhere('sales', 'LIKE',"%{$search}%")
                ->count();
                // dd($opi);
            }
            
            $data = array();
            if (!empty($kontrak)) {
                foreach ($kontrak as $kontrak)
                {
                    $show =  route('kontrak.pdfb1',$kontrak->id);
                    
                    if ($kontrak->status == 4 || $kontrak->status == 3 && Auth::user()->divisi_id == 2) {
                        $edit =  route('kontrak.edit',$kontrak->id);
                        $cancel = route('kontrak.cancel', $kontrak->id);
                        $open = route('kontrak.open', $kontrak->id);
                    } else if ($kontrak->status == 2) {  
                        $edit =  route('kontrak.edit',$kontrak->id);
                        $cancel = null;
                        $open = null;
                    } else if ($kontrak->status == 3 || $kontrak->status == 5) {  
                        $edit =  null;
                        $cancel = null;
                        $open = null;
                    }
                    
                    $dt =  route('kontrak.dt',$kontrak->id);
                    $kirim =  route('kontrak.realisasi',$kontrak->id);
                    
                    if ($kontrak->status == 2) {
                        $color = '#ff9800';
                        $status = "<div class='status label warning'>Opened</div>";
                    } else if ($kontrak->status == 3) {
                        $color = '#2196F3';
                        $status = "<div class='status label info'>Closed</div>";
                    } else if ($kontrak->status == 4) {
                        $color = 'black';
                        $status = "<div class='status label success'>Processed</div>";
                    } else if ($kontrak->status == 5) {
                        $color = 'f44336';
                        $status = "<div class='status label danger'>Cancel</div>";
                    }
                    
                    // if($kontrak->status == 2 || $kontrak->status == 3 ){
                        $nestedData['id'] = "<p style='color:".$color."'>".$kontrak->id."</p>";
                        $nestedData['kontrak'] = "<p style='color:".$color."'>".$kontrak->kode."</p>";
                        $nestedData['cust'] = "<p style='color:".$color."'>".$kontrak->customer_name."</p>";
                        $nestedData['tglKontrak'] = "<p style='color:".$color."'>".$kontrak->tglKontrak."</p>";
                        $nestedData['alamatKirim'] = "<p style='color:".$color."'>".$kontrak->alamatKirim."</p>";
                        $nestedData['custTelp'] = "<p style='color:".$color."'>".$kontrak->custTelp."</p>";
                        $nestedData['poCustomer'] = "<p style='color:".$color."'>".$kontrak->poCustomer."</p>";
                        $nestedData['top'] = "<p style='color:".$color."'>".$kontrak->top."</p>";
                        $nestedData['sales'] = "<p style='color:".$color."'>".$kontrak->sales."</p>";
                        $nestedData['tipeOrder'] = "<p style='color:".$color."'>".$kontrak->tipeOrder."</p>";
                        $nestedData['keterangan'] = "<p style='color:".$color."'>".$kontrak->keterangan."</p>";
                        $nestedData['tipeOrder'] = "<p style='color:".$color."'>".$kontrak->tipeOrder."</p>";

                        // if ($kontrak->status == 2) {
                        // } else {
                        // }

                        $nestedData['status'] = $status;
                        
                        // Realisasi Kirim
                        $terkirim = 0;
                        $dataRealisasi = [];
                        foreach ($kontrak->realisasi as $realisasi) {
                            
                            $dataRealisasi[] = 
                            "&emsp;<li><span class='glyphicon glyphicon-list'>".$realisasi->qty_kirim." ( ".date('d F', strtotime($realisasi->tanggal_kirim)).")</span></li>";
                            
                            $terkirim = $terkirim + $realisasi->qty_kirim;
                        }
                        
                        if (Auth::user()->divisi_id == 2) {
                            $nestedData['komisi'] = "<p style='color:".$color."'>".$kontrak->komisi."</p>";
                        } else {
                            $nestedData['komisi'] = "<p style='color:".$color."'>0</p>";
                        }
                        
                        $nestedData['realisasi'] = $dataRealisasi;
                        $nestedData['pcsKontrak'] = "<p style='color:".$color."'>".$kontrak->kontrak_d['pcsKontrak']."</p>";
                        $nestedData['kgKontrak'] = "<p style='color:".$color."'>".$kontrak->kontrak_d['kgKontrak']."</p>";
                        
                        $sisakontrak = $kontrak->kontrak_d['pcsKontrak'] - $terkirim;

                        if ($sisakontrak < 0) {
                            $sisakontrak = 0;
                        } else {
                            $sisakontrak = $sisakontrak;
                        }
                        
                        $nestedData['sisaKirim'] = "<p style='color:".$color."'>".$sisakontrak."</p>";
                        $nestedData['rp_pcs'] = "<p style='color:".$color."'>".$kontrak->kontrak_d['harga_pcs']."</p>";
                        
                        $mc = Mastercard::find($kontrak->kontrak_d->mc_id);
                        // $mcKode = ($mc->revisi != '' ? $mc->kode.'-'.$mc->revisi : $mc->kode);
                        
                        if($mc->revisi == ''){
                            $mcKode = $mc->kode;
                        } else if ($mc->revisi == "R0"){
                            $mcKode = $mc->kode;
                        } else {
                            $mcKode = $mc->kode.'-'.$mc->revisi;
                        }
                        
                        $nestedData['brt_kualitas'] = "<p style='color:".$color."'>".$mc->gramSheetBoxKontrak."</p>" ;
                        $nestedData['nomc'] = "<p style='color:".$color."'>".$mcKode."</p>";
                        $nestedData['kodeBarang'] = "<p style='color:".$color."'>".$mc->kodeBarang."</p>";
                        $nestedData['namaBarang'] = "<p style='color:".$color."'>".$mc->namaBarang."</p>";
                        $nestedData['action'] = "&emsp;<button><a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'>Print</span></a></button>
                        &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'>Edit</span></a>&emsp;<a href='{$dt}' title='SHOW' ><span class='glyphicon glyphicon-list'>DT</span></a>&emsp;<a href='{$kirim}' title='SHOW' ><span class='glyphicon glyphicon-list'>Kirim</span></a>&emsp;<a href='{$cancel}' title='SHOW' ><span class='glyphicon glyphicon-list'>Cancel</span></a>&emsp;<a href='{$open}' title='SHOW' ><span class='glyphicon glyphicon-list'>Open</span></a>";
                        
                        $nestedData['b_expedisi'] = "<p style='color:".$color."'>".$kontrak->biaya_exp."</p>";
                        $nestedData['b_glue'] = "<p style='color:".$color."'>".$kontrak->biaya_glue."</p>";
                        $nestedData['b_wax'] = "<p style='color:".$color."'>".$kontrak->biaya_wax."</p>";
                        if ($mc->tipeBox == 'SF') {
                            $nestedData['rp_kg'] = "<p style='color:".$color."'>".number_format($kontrak->kontrak_d['harga_pcs'],2,',','.')."</p>";
                        } else {
                            $rpkg = $kontrak->kontrak_d['harga_pcs'] / $mc->gramSheetBoxKontrak;

                            $nestedData['rp_kg'] = "<p style='color:".$color."'>".number_format($rpkg,2,',','.')."</p>";
                        }
                    $data[] = $nestedData;
                }
            }
            
            $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data,
                "start"           => $start,
                "limit"           => $limit
            );
            
            echo json_encode($json_data); 
        }

        public function getOpenKontrak(Request $request)
        {
            if ($request->ajax()) {
                $kontrak = Kontrak_M::where('status', 2)->get();

                return DataTables::of($kontrak)
                    ->addColumn('action', function($kontrak){
                        return "&emsp;<a href='".route('kontrak.edit',$kontrak->id)."' title='EDIT' ><span class='glyphicon glyphicon-edit'>Edit</span></a>";
                    })
                    ->make(true);
            }

            return view('admin.kontrak.open_kontrak');
        }
        
        public function index(Request $request)
        {            
            
            return view('admin.kontrak.index');
            // $kontrak_m = Kontrak_M::get();
            
            // return view('admin.kontrak.index',compact('kontrak_m'));
        }
        
        /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function create()
        {
            
            $cust = DB::connection('firebird')->table('TCustomer')->get();
            $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease', 'box.namaBarang as box')
            ->where('mc.status', '=', '1')
            ->get();
            $top = DB::table('top')->get();
            $sales = DB::table('sales_m')
            ->where('aktif', '=', 1)
            ->orderBy('nama', 'Asc')
            ->get();
            
            return view('admin.kontrak.newcreate', compact(
                'mc', 'top', 'cust', 'sales'
            ));
        }
        
        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
            //ambil url/ No Bukti halaman
            $url = Route::currentRouteName(); //output kontrak.store
            
            //ambil noBukti dari number_sequence table
            $ns = DB::table('number_sequence')
            ->select('format')
            ->where('noBukti', '=', $url)->get(); //ambil format yg sesuai url/nobukti
            
            $nobukti = $ns[0]->format;
            $tanggal = $request->tanggal;
            
            // dd($nobukti, $tanggal);
            
            $start = Carbon::createFromFormat('Y-m-d', $tanggal)
            ->firstOfMonth()
            ->format('Y-m-d');
            
            $end = Carbon::createFromFormat('Y-m-d', $tanggal)
            ->endOfMonth()
            ->format('Y-m-d');
            
            $fromDate = Carbon::now()->startOfMonth();
            $tillDate = Carbon::now()->endOfMonth();
            
            if (strpos($fromDate, $start) !== false ) {
                $result = Kontrak_M::whereBetween(DB::raw('date(tglKontrak)'), [$fromDate, $tillDate])->get();
                $count = count($result)+1;
                if ($nobukti === $nobukti) {
                    $nobukti = str_replace('~YYYY~', date('Y'), $nobukti);
                    $nobukti = str_replace('~MM~', date('m'), $nobukti);                
                    $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
                }
            } else {
                $result = Kontrak_M::whereBetween(DB::raw('date(tglKontrak)'), [$start, $end])->get();
                $count = count($result)+2;
                if ($nobukti === $nobukti) {
                    $nobukti = str_replace('~YYYY~', date('Y', strtotime($start)), $nobukti);
                    $nobukti = str_replace('~MM~', date('m', strtotime($start)), $nobukti);                
                    $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
                }
            }
            
            
            // dd($nobukti, $request->all());
            
            // Insert Into ke table
            $kontrakm = Kontrak_M::create([   
                'kode' => $nobukti,
                'tglKontrak' => $request->tanggal,
                'top' => $request->top,
                'poCustomer' => $request->poCustomer,
                'customer_name' => $request->namaCust,
                'alamatKirim' => $request->alamatKirim,
                'caraKirim' => $request->caraKirim,
                'sales' => $request->sales,
                'tipeOrder' => $request->tipeOrder,
                'createdBy' => $request->createdBy,
                'keterangan' => $request->keterangan,
                'komisi' => $request->komisi,
                'biaya_exp' => $request->biaya_exp,
                'biaya_glue' => $request->biaya_glue,
                'biaya_wax' => $request->biaya_wax,
                'min_tgl_kirim' => $request->tglkirim
            ]);
            // End Insert Into
            
            // dd($kontrakm);
            
            $tax = 0 ;
            $sblTax = 0 ;
            $total = 0 ;
            $kontrakd = Kontrak_D::create([
                'kontrak_m_id' => $kontrakm->id,
                'mc_id' => $request->mcid,
                'pcsKontrak' => $request->qtyPcs,
                // + $request->pcsToleransiLebih + $request->kgToleransiLebih
                'pcsSisaKontrak' => $request->qtyPcs,
                'kgKontrak' => $request->qtyKg,
                'kgSisaKontrak' => $request->qtyKg,
                'pctToleransiLebihKontrak' => $request->toleransiLebih,
                'pctToleransiKurangKontrak' => $request->toleransiKurang,
                'pcsLebihToleransiKontrak' => $request->toleransiLebihPcs,
                'kgLebihToleransiKontrak' => $request->toleransiLebihKg,
                'pcsKurangToleransiKontrak' => $request->toleransiKurangPcs,
                'kgKurangToleransiKontrak' => $request->toleransiKurangKg,
                'harga_pcs' => $request->harga,
                'tax' => $request->ppn,
                'amountBeforeTax' => $request->total,
                'ppn' => $request->hargappn,
                'amountTotal' => $request->total + $request->hargappn,
                'harga_kg' => $request->hargakg,
                'createdBy' => $request->createdBy,
            ]);
            
            $upMaster = Kontrak_M::find($kontrakm->id); // finding row sesuai id untuk update ke table
            Tracking::create([
                'user' => Auth::user()->name,
                'event' => "Tambah Kontrak ".$upMaster->kode
            ]);
            
            $upMaster->amountBeforeTax = $request->total; // update database field amountBefireTax dengan value sblTax
            $upMaster->tax = $request->hargappn;
            $upMaster->amountTotal = $request->total + $request->hargappn;
            
            $upMaster->save(); // simpan ke table
            
            return redirect('admin/kontrak')->with('success', "Data Berhasil disimpan dengan kode Kontrak = ". $nobukti);
        }
        
        /**
        * Display the specified resource.
        *
        * @param  \App\Models\Kontrak_D  $kontrak_D
        * @return \Illuminate\Http\Response
        */
        public function show(Kontrak_D $kontrak_D)
        {
            //  
        }
        
        /**
        * Show the form for editing the specified resource.
        *
        * @param  \App\Models\Kontrak_D  $kontrak_D
        * @return \Illuminate\Http\Response
        */
        public function edit($id)
        {
            // menampilkan untuk dropdown
            $cust = DB::connection('firebird')->table('TCustomer')->get();
            
            $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease','box.namaBarang as box')
            ->get();
            $top = DB::table('top')->get();
            $sales = DB::table('sales_m')
            ->orderBy('nama', 'Asc')
            ->get();
            // End Dropdown
            
            
            // tampilkan data yang akan di edit
            $kontrak_D = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
            ->leftJoin('box', 'mc.box_id', '=', 'box.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.tipeMc as tipeMc', 'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', 'box.namaBarang as box', 'mc.tipeBox as tipeBox','mc.flute as flute', 'color_combine.nama as warna')
            ->first();
            
            $kontrak_M = DB::table('kontrak_m')
            ->where('kontrak_m.id', '=', $id)
            ->first();
            // End tampilkan untuk edit
            
            
            // dd($kontrak_D);
            // $count = count($kontrak_D);
            
            
            // dd($kontrak_M);
            return view('admin.kontrak.edit', compact(
                'cust',
                'mc',
                'top',
                'sales',
                // 'count',
                'kontrak_D'
            ), ['kontrak_M' => $kontrak_M]);
        }
        
        public function add_dt($id)
        {
            // menampilkan untuk dropdown
            // $cust = DB::connection('firebird')->table('TCustomer')->get();
            
            $date = date('Y-m-d');
            // dd($date);
            
            $b1 = DB::table('opi_m')
            ->join('dt', 'dt_id', 'dt.id')
            ->join('mc', 'mc_id', 'mc.id')
            ->select(DB::raw("SUM(opi_m.jumlahOrder) as qty"), 'opi_m.tglKirimDt', 'mc.tipeBox')
            ->where('mc.tipeBox', '=', 'B1')
            ->where('opi_m.tglKirimDt', '>=', $date)
            ->where('opi_m.status_opi', '=', 'Proses')
            ->groupBy('opi_m.tglKirimDt')
            ->get();
            
            $dc = DB::table('opi_m')
            ->join('dt', 'dt_id', 'dt.id')
            ->join('mc', 'mc_id', 'mc.id')
            ->select(DB::raw("ROUND(SUM(opi_m.jumlahOrder / mc.outConv )) as qty"), 'opi_m.tglKirimDt', 'mc.tipeBox')
            ->where('mc.tipeBox', '=', 'DC')
            ->where('opi_m.tglKirimDt', '>=', $date)
            ->where('opi_m.status_opi', '=', 'Proses')
            ->groupBy('opi_m.tglKirimDt')
            ->get();
            
            // // dd($b1, $dc);
            
            $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            ->get();
            $top = DB::table('top')->get();
            $sales = DB::table('sales_m')->get();
            // End Dropdown
            
            
            // tampilkan data yang akan di edit
            $kontrak_D = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.tipeMc as tipeMc', 'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', 'mc.tipeBox as tipebox', 'mc.gramSheetCorrKontrak as berat', 'mc.outConv as outConv')
            ->first();
            
            $kontrak_M = DB::table('kontrak_m')
            ->where('kontrak_m.id', '=', $id)
            ->first();
            
            $opi = Opi_M::opidt()->where('opi_m.kontrak_m_id', '=', $id)
            ->get();
            // End tampilkan untuk edit
            
            
            // dd($opi);
            // $count = count($kontrak_D);
            
            
            // dd($kontrak_M);
            return view('admin.kontrak.data_dt', compact(
                // 'cust',
                'b1',
                'dc',
                'mc',
                'top',
                'sales',
                'opi',
                'kontrak_D'
            ), ['kontrak_M' => $kontrak_M]);
        }
        
        public function store_dt(Request $request)
        {
            $date = date_create($request->tglKirim);
            $day = date_format($date, "D");
            $alphabet = 'E';
            $tahun = '2025';
            
            if ($request->tglKirim != null) {
                $lastOpi = Opi_M::where('periode', '=', $tahun) 
                ->first();
                
                if($lastOpi === null){
                    $numb_opi = '0001'.$alphabet;
                    // dd($numb_opi);
                } else {
                    $lastOpi = Opi_M::where('periode', '=', $tahun)->get();
                    $numb_opi = str_pad(count($lastOpi)+1,4, '0', STR_PAD_LEFT).$alphabet;
                    // dd($numb_opi);
                };
                
                
                $checkMesin = Opi_M::opi()->where('dt.tglKirimDt', '=', $request->tglKirim)->get();
                
                $totalB1 = 0;
                $totaldc = 0;
                $lain = 0;
                
                if ($request->tipebox == 'B1') {
                    $b1 = DB::table('opi_m')
                    ->join('dt', 'dt_id', 'dt.id')
                    ->join('mc', 'mc_id', 'mc.id')
                    ->select(DB::raw("SUM(opi_m.jumlahOrder / mc.outConv) as qty"), 'opi_m.tglKirimDt', 'mc.tipeBox')
                    ->where('mc.tipeBox', '=', 'B1')
                    ->where('status_opi', '=', 'Proses')
                    ->where('opi_m.tglKirimDt', '>=', $request->tglKirim)
                    ->groupBy('opi_m.tglKirimDt')
                    ->first();
                    if ($b1 != null) {
                        $totalB1 = $b1->qty;
                    } else {
                        $totalB1 = 0;
                    }
                } elseif ($request->tipebox == 'DC') {
                    $dc = DB::table('opi_m')
                    ->join('dt', 'dt_id', 'dt.id')
                    ->join('mc', 'mc_id', 'mc.id')
                    ->select(DB::raw("SUM(opi_m.jumlahOrder / mc.outConv) as qty"), 'opi_m.tglKirimDt', 'mc.tipeBox')
                    ->where('mc.tipeBox', '=', 'DC')
                    ->where('status_opi', '=', 'Proses')
                    ->where('opi_m.tglKirimDt', '>=', $request->tglKirim)
                    ->groupBy('opi_m.tglKirimDt')
                    ->first();
                    
                    if ($dc != null) {
                        $totaldc = $dc->qty;
                    } else {
                        $totaldc = 0;
                    }
                }
                
                $checkOpi = Opi_M::where('nama', '=', $numb_opi )->first();
                
                if ($checkOpi == null) {
                    $kontrakd = Kontrak_D::where('kontrak_m_id', '=', $request->idkontrakm)->first();
                    $kontrakm = Kontrak_M::where('id', '=', $request->idkontrakm)->first();
                    
                    if ($request->jumlahKirim > $kontrakd->pcsSisaKontrak) {
                        return redirect()->to(url()->previous())->with('success', 'Sisa kontrak tidak mencukupi, maksimal '.$kontrakd->pcsSisaKontrak);
                    } else {
                        if ($request->tipebox == 'B1') {
                            if (($request->jumlahKirim/$request->outconv) + $totalB1 > 150000) {
                                
                                $dt = DeliveryTime::create([
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'opi' => $numb_opi,
                                    'kodeKontrak' => $request->kode,
                                    'tglKirimDt' => $request->tglKirim,
                                    'locked' => 1,
                                    'pcsDt' => $request->jumlahKirim,
                                    'createdBy' => Auth::user()->name,
                                ]);
                                
                                $opim = Opi_M::create([   
                                    'nama' => $numb_opi,
                                    'periode' => $tahun,
                                    'NoOPI' => $numb_opi,
                                    'dt_id' => $dt->id,
                                    'mc_id' => $kontrakd->mc_id,
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'kontrak_d_id' => $kontrakd->id,
                                    'keterangan' => $kontrakm->keterangan,
                                    'tglKirimDt' => $request->tglKirim,
                                    'jumlahOrder' => $request->jumlahKirim,
                                    'sisa_order' => $request->jumlahKirim,
                                    'hariKirimDt' => $day,
                                    'status_opi' => 'Proses',
                                    'createdBy' => Auth::user()->name,
                                    'os_corr' => $request->jumlahKirim,
                                    'os_flx' => $request->jumlahKirim,
                                    'os_fin' => $request->jumlahKirim,
                                ]);
                                
                                Tracking::create([
                                    'user' => Auth::user()->name,
                                    'event' => "Tambah OPI ".$opim->nama
                                ]);
                                
                                return redirect()->to(url()->previous())->with('success', 'Kapasitas OPI B1 pada tanggal '.$request->tglKirim.' sudah maksimal silahkan Kontak pihak PPIC untuk approve DT');
                            } else {
                                $dt = DeliveryTime::create([
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'opi' => $numb_opi,
                                    'kodeKontrak' => $request->kode,
                                    'tglKirimDt' => $request->tglKirim,
                                    'pcsDt' => $request->jumlahKirim,
                                    'createdBy' => Auth::user()->name,
                                ]);
                                
                                $opim = Opi_M::create([   
                                    'nama' => $numb_opi,
                                    'periode' => $tahun,
                                    'NoOPI' => $numb_opi,
                                    'dt_id' => $dt->id,
                                    'mc_id' => $kontrakd->mc_id,
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'kontrak_d_id' => $kontrakd->id,
                                    'keterangan' => $kontrakm->keterangan,
                                    'tglKirimDt' => $request->tglKirim,
                                    'jumlahOrder' => $request->jumlahKirim,
                                    'sisa_order' => $request->jumlahKirim,
                                    'hariKirimDt' => $day,
                                    'createdBy' => Auth::user()->name,
                                    'os_corr' => $request->jumlahKirim,
                                    'os_flx' => $request->jumlahKirim,
                                    'os_fin' => $request->jumlahKirim,
                                ]);
                                
                                Tracking::create([
                                    'user' => Auth::user()->name,
                                    'event' => "Tambah OPI ".$opim->nama
                                ]);
                                
                                $kontrakd->pcsSisaKontrak = $kontrakd->pcsSisaKontrak - $request->jumlahKirim;
                                $kontrakd->kgSisaKontrak = ($kontrakd->kgSisaKontrak*$request->berat) - ($request->jumlahOrder*$request->berat);
                                $kontrakd->save();
                            }
                        } elseif($request->tipebox == 'DC') {
                            // dd($request->outconv);
                            if (($request->jumlahKirim/$request->outconv) + $totaldc > 54000) {
                                $dt = DeliveryTime::create([
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'opi' => $numb_opi,
                                    'kodeKontrak' => $request->kode,
                                    'tglKirimDt' => $request->tglKirim,
                                    'locked' => 1,
                                    'pcsDt' => $request->jumlahKirim,
                                    'createdBy' => Auth::user()->name,
                                ]);
                                
                                $opim = Opi_M::create([   
                                    'nama' => $numb_opi,
                                    'periode' => $tahun,
                                    'NoOPI' => $numb_opi,
                                    'dt_id' => $dt->id,
                                    'mc_id' => $kontrakd->mc_id,
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'kontrak_d_id' => $kontrakd->id,
                                    'keterangan' => $kontrakm->keterangan,
                                    'tglKirimDt' => $request->tglKirim,
                                    'jumlahOrder' => $request->jumlahKirim,
                                    'sisa_order' => $request->jumlahKirim,
                                    'hariKirimDt' => $day,
                                    'status_opi' => 'Proses',
                                    'createdBy' => Auth::user()->name,
                                ]);
                                
                                Tracking::create([
                                    'user' => Auth::user()->name,
                                    'event' => "Tambah OPI ".$opim->nama
                                ]);
                                
                                return redirect()->to(url()->previous())->with('success', 'Kapasitas OPI DC pada tanggal '.$request->tglKirim.' sudah maksimal silahkan Kontak pihak PPIC untuk approve DT');
                            } else {
                                $dt = DeliveryTime::create([
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'opi' => $numb_opi,
                                    'kodeKontrak' => $request->kode,
                                    'tglKirimDt' => $request->tglKirim,
                                    'pcsDt' => $request->jumlahKirim,
                                    'createdBy' => Auth::user()->name,
                                ]);
                                
                                $opim = Opi_M::create([   
                                    'nama' => $numb_opi,
                                    'periode' => $tahun,
                                    'NoOPI' => $numb_opi,
                                    'dt_id' => $dt->id,
                                    'mc_id' => $kontrakd->mc_id,
                                    'kontrak_m_id' => $request->idkontrakm,
                                    'kontrak_d_id' => $kontrakd->id,
                                    'keterangan' => $kontrakm->keterangan,
                                    'tglKirimDt' => $request->tglKirim,
                                    'jumlahOrder' => $request->jumlahKirim,
                                    'sisa_order' => $request->jumlahKirim,
                                    'hariKirimDt' => $day,
                                    'createdBy' => Auth::user()->name,
                                    'os_corr' => $request->jumlahKirim,
                                    'os_flx' => $request->jumlahKirim,
                                    'os_fin' => $request->jumlahKirim,
                                ]);
                                
                                Tracking::create([
                                    'user' => Auth::user()->name,
                                    'event' => "Tambah OPI ".$opim->nama
                                ]);
                                
                                $kontrakd->pcsSisaKontrak = $kontrakd->pcsSisaKontrak - $request->jumlahKirim;
                                $kontrakd->kgSisaKontrak = ($kontrakd->kgSisaKontrak*$request->berat) - ($request->jumlahOrder*$request->berat);
                                $kontrakd->save();
                            }
                        } else {
                            $dt = DeliveryTime::create([
                                'kontrak_m_id' => $request->idkontrakm,
                                'opi' => $numb_opi,
                                'kodeKontrak' => $request->kode,
                                'tglKirimDt' => $request->tglKirim,
                                'pcsDt' => $request->jumlahKirim,
                                'createdBy' => Auth::user()->name,
                            ]);
                            
                            $opim = Opi_M::create([   
                                'nama' => $numb_opi,
                                'periode' => $tahun,
                                'NoOPI' => $numb_opi,
                                'dt_id' => $dt->id,
                                'mc_id' => $kontrakd->mc_id,
                                'kontrak_m_id' => $request->idkontrakm,
                                'kontrak_d_id' => $kontrakd->id,
                                'keterangan' => $kontrakm->keterangan,
                                'tglKirimDt' => $request->tglKirim,
                                'jumlahOrder' => $request->jumlahKirim,
                                'sisa_order' => $request->jumlahKirim,
                                'hariKirimDt' => $day,
                                'createdBy' => Auth::user()->name,
                                'os_corr' => $request->jumlahKirim,
                                'os_flx' => $request->jumlahKirim,
                                'os_fin' => $request->jumlahKirim,
                            ]);
                            
                            Tracking::create([
                                'user' => Auth::user()->name,
                                'event' => "Tambah Box ".$opim->nama
                            ]);
                            
                            $kontrakd->pcsSisaKontrak = $kontrakd->pcsSisaKontrak - $request->jumlahKirim;
                            $kontrakd->kgSisaKontrak = ($kontrakd->kgSisaKontrak*$request->berat) - ($request->jumlahOrder*$request->berat);
                            $kontrakd->save();
                        }
                    }
                }
            }
            return redirect()->to(url()->previous())->with('success', 'Data DT dan OPI Berhasi disimpan dengan Nomor OPI'.$numb_opi );
        }
        
        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Models\Kontrak_D  $kontrak_D
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $id)
        {
            $kontrakm =Kontrak_M::find($id);
            
            // untuk set value yang di update
            $kontrakm->customer_name = $request->namaCust;
            $kontrakm->alamatKirim = $request->alamatKirim;
            $kontrakm->custTelp = $request->telp;
            $kontrakm->poCustomer = $request->poCustomer;
            $kontrakm->tipeOrder = $request->tipeOrder;
            $kontrakm->tglKontrak = $request->tanggal;
            $kontrakm->sales = $request->sales;
            $kontrakm->top = $request->top;
            $kontrakm->komisi = $request->komisi;
            $kontrakm->caraKirim = $request->caraKirim;
            $kontrakm->keterangan = $request->keterangan;
            $kontrakm->min_tgl_kirim = $request->tglkirim;
            $kontrakm->biaya_exp = $request->biaya_exp;
            $kontrakm->biaya_glue = $request->biaya_glue;
            $kontrakm->biaya_wax = $request->biaya_wax;
            $kontrakm->status = 4;
            $kontrakm->lastUpdatedBy = Auth::user()->name;
            // End untuk set value yang di update
            
            $kontrakm->save();
            
            $kontrakd = Kontrak_D::find($request->kontrakd_id);
            
            $kontrakd->mc_id = $request->mcid;
            $kontrakd->pcsKontrak = $request->qtyPcs;
            $kontrakd->kgKontrak = $request->qtyKg;
            $kontrakd->harga_pcs = $request->harga;
            $kontrakd->harga_kg = $request->hargakg;
            $kontrakd->pcsSisaKontrak = $request->qtyPcs;
            $kontrakd->kgSisaKontrak = $request->qtyKg;
            $kontrakd->pctToleransiLebihKontrak = $request->toleransiLebih;
            $kontrakd->pctToleransiKurangKontrak = $request->toleransiKurang;
            $kontrakd->pcsKurangToleransiKontrak = $request->toleransiKurangPcs;
            $kontrakd->pcsLebihToleransiKontrak = $request->toleransiLebihPcs;
            $kontrakd->kgKurangToleransiKontrak = $request->toleransiKurangKg;
            $kontrakd->kgLebihToleransiKontrak = $request->toleransiLebihKg;
            $kontrakd->lastUpdatedBy = Auth::user()->name;
            
            $kontrakd->save();            

            $realisasi = RealisasiKirim::leftJoin('kontrak_m', 'realisasi_kirim.kontrak_m_id', '=', 'kontrak_m.id')
            ->select(DB::raw('sum(qty_kirim) as qty'), 'kontrak_m.kode')
            ->where('realisasi_kirim.kontrak_m_id', '=', $id)
            ->first();

            if ($realisasi->qty != null) {
                if ($realisasi->qty >= $kontrakm->pcsKontrak) {
                    $kontrakm->status = 3;
                    $kontrakm->save();
                } 
            }
            
            Tracking::create([
                'user' => Auth::user()->name,
                'event' => "Ubah Kontrak ".$kontrakm->kode
            ]);
            // dd($kontrakd);
            return redirect('admin/kontrak');
        }
        
        /**
        * Remove the specified resource from storage.
        *
        * @param  \App\Models\Kontrak_D  $kontrak_D
        * @return \Illuminate\Http\Response
        */
        public function destroy(Kontrak_D $kontrak_D)
        {
            //
        }
        
        public function pdfprint($id){
            
            
            $cust = DB::connection('firebird')->table('TCustomer')->get();
            
            $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            ->get();
            $top = DB::table('top')->get();
            $sales = DB::table('sales_m')->get();
            // End Dropdown
            
            
            // tampilkan data yang akan di edit
            $kontrakBox = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            // ->where('tipe', '=', 'BOX')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.wax as wax', 'mc.tipeMc as tipeMc', 'box.panjangDalamBox as panjangBox', 'box.lebarDalamBox as lebarBox', 'box.tinggiDalamBox as tinggiBox', 'mc.panjangSheetBox as panjangSheetBox', 'mc.lebarSheetBox as lebarSheetBox',  'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', 'mc.namaBarang as Barang', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease', 'mc.flute as flute', 'mc.tipeBox as tipeBox', 'mc.koli as koli', 'mc.joint as joint', 'mc.bungkus as bungkus', 'mc.keterangan as keterangan')
            ->first();
            // dd($kontrakBox);
            
            // $mytime = Carbon::now();
            
            $kontrak_D = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('box', 'mc.box_id', '=', 'box.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->where('tipe', '!=', 'BOX')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.wax as wax', 'mc.tipeMc as tipeMc', 'mc.panjangSheetBox as panjangSheetBox', 'mc.lebarSheetBox as lebarSheetBox',  'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', 'mc.namaBarang as Barang', 'mc.flute as flute', 'mc.tipeBox as tipeBox', 'mc.koli as koli', 'mc.joint as joint', 'mc.bungkus as bungkus','box.panjangDalamBox as panjangBox', 'box.lebarDalamBox as lebarBox', 'box.tinggiDalamBox as tinggiBox', 'kontrak_d.pcsKontrak as qtyKontrak', 'kontrak_d.harga_pcs as harga', 'kontrak_d.pctToleransiLebihKontrak as lebih', 'kontrak_d.pctToleransiKurangKontrak as kurang' )
            ->get();
            // dd($kontrak_D);
            
            $kontrak_M = DB::table('kontrak_m')
            ->where('kontrak_m.id', '=', $id)
            ->first();
            // End tampilkan untuk edit
            $dt = DB::table('dt')
            ->where('kontrak_m_id', '=', $id)
            ->get();
            
            $date = date_create($kontrak_M->tglKontrak);
            
            $count = count($kontrak_D);
            
            
            // dd($kontrak_M);
            return view('admin.kontrak.pdf', compact(
                'cust',
                'mc',
                'top',
                'sales',
                'count',
                'kontrak_D',
                'kontrakBox',
                'dt',
                'date',
            ), ['kontrak_M' => $kontrak_M]);
        }
        
        public function add_realisasi($id)
        {
            
            DB::connection('firebird2')->beginTransaction();
            
            $kontrak_D = Kontrak_D::where('kontrak_m_id', '=', $id)->first();
            
            $opi = DB::table('opi_m')->where('kontrak_m_id', '=', $id)->get();            
            
            $kontrak_M =Kontrak_M::where('kontrak_m.id', '=', $id)
            ->first();
            $sj = DB::connection('firebird2')->table('TDetSJ')
            ->leftJoin('TSuratJalan', 'TDetSJ.NomerSJ', 'TSuratJalan.NomerSJ')
            ->select('TDetSJ.NomerSJ as nomer', 'TSuratJalan.Periode', 'TSuratJalan.NamaCust', 'TSuratJalan.NomerMOD', 'TDetSJ.Quantity', 'TSuratJalan.TglSJ')
            ->where('TSuratJalan.NamaCust', 'LIKE', $kontrak_M->customer_name)
            ->get();

            // dd($sj);

            $kontrakMaster = DB::table('kontrak_d')
            ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->where('kontrak_m.customer_name', 'Like', $kontrak_M->customer_name)
            ->select('pcsKontrak', 'kontrak_m.*')
            ->orderBy('id', 'desc')
            ->get();

            // dd($kontrakMaster);
            
            return view('admin.kontrak.data_realisasi', compact(
                'kontrak_D', 
                'kontrak_M', 
                'opi',
                'kontrakMaster',
                'sj'
            ));
        }
        
        public function store_realisasi(Request $request)
        {
            $id = array_merge($request->idkontrak);
            for ($i=0; $i < count($id); $i++) { 
                $kontrak = Kontrak_D::where('kontrak_m_id', "=", $id[$i])->first();
                $kontrakm = Kontrak_M::where('id', '=', $id)->first();
                $qty = intval(str_replace(',','',$request->jumlahKirim));
                $mc = Mastercard::where('id', "=", $kontrak->mc_id)->first();          
                RealisasiKirim::create([
                    'kontrak_m_id'  => $id[$i],
                    'tanggal_kirim' => $request->tglKirim,
                    'nomer_sj'      => $request->sj,
                    'mod'           => $request->mod,
                    'qty_kirim'     => $qty,
                    'kg_kirim'      => $qty * $mc->gramSheetBoxKontrak,
                    'createdBy'     => Auth::user()->name
                ]);
                
                Tracking::create([
                    'user' => Auth::user()->name,
                    'event' => "Tambah Realisasi Kirim SJ ". $request->sj
                ]);

                $realisasi = RealisasiKirim::leftJoin('kontrak_m', 'realisasi_kirim.kontrak_m_id', '=', 'kontrak_m.id')
                        ->select(DB::raw('sum(qty_kirim) as qty'), 'kontrak_m.kode')
                        ->where('realisasi_kirim.kontrak_m_id', '=', $id[$i])
                        ->first();

                if ($realisasi->qty >= $kontrak->pcsKontrak) {
                    $kontrakm->status = 3;
                    $kontrakm->save();
                } 
            }
            
            return redirect('admin/kontrak');
        }
        
        public function edit_realisasi(Request $request, $id)
        {
            $kirim = RealisasiKirim::findOrFail($id);

            $kontrak = Kontrak_D::where('kontrak_m_id', "=", $kirim->kontrak_m_id)->first();
            $kontrakm = Kontrak_M::where('id', '=', $kontrak->kontrak_m_id)->first();
            $mc = Mastercard::where('id', "=", $kontrak->mc_id)->first();   

            // dd($id);
            
            $kirim->update([
                'tanggal_kirim' => $request->tglKirim,
                'qty_kirim' => $request->jumlahKirim,
                'kg_kirim'      => $request->jumlahKirim * $mc->gramSheetBoxKontrak,
            ]);

            Tracking::create([
                'user' => Auth::user()->name,
                'event' => "Ubah Realisasi Kirim SJ ". $kirim->nomer_sj
            ]);

            $realisasi = RealisasiKirim::leftJoin('kontrak_m', 'realisasi_kirim.kontrak_m_id', '=', 'kontrak_m.id')
                        ->select(DB::raw('sum(qty_kirim) as qty'), 'kontrak_m.kode')
                        ->where('realisasi_kirim.kontrak_m_id', '=', $kontrakm->id)
                        ->first();
                        

                if ($realisasi->qty >= $kontrak->pcsKontrak) {
                    $kontrakm->status = 3;
                    $kontrakm->save();
                } 
            
            return redirect()->to(url()->previous())->with('success', 'Berhasil Disimpan');
            
        }
        
        public function cancel_kontrak($id)
        {
            $kontrak = Kontrak_M::find($id);
            $kontrak->status = 5;
            
            Tracking::create([
                'user' => Auth::user()->name,
                'event' => "Cancel Kontrak". $kontrak->kode
            ]);
            
            $kontrak->save();
            return redirect('admin/kontrak')->with('success', 'Kontrak Berhasil di Cancel');
        }
        
        public function open_kontrak($id)
        {
            $kontrak = Kontrak_M::find($id);
            $kontrak->status = 2;
            
            $notif = Notification::where('kontrak_id', '=', $id)
                    ->where('status', '=', 'Proses')
                    ->first();

            $notif->pic = Auth::user()->name;
            $notif->status = 'Done';
    
            $notif->save();        
            Tracking::create([
                'user' => Auth::user()->name,
                'event' => "Open Kontrak ". $kontrak->kode
            ]);
            
            $kontrak->save();
            return redirect()->back()->with('success', 'Kontrak Berhasil di Buka');
        }

        public function recall($id) 
        {
            $order = 0;
            $kirim = 0;
            $kontrak = Kontrak_D::where("kontrak_m_id", "=", $id)->first();
            $kontrakm = Kontrak_M::where("id", "=", $id)->first();
            $opi = Opi_M::where("kontrak_m_id", "=", $id)->get();
            $realisasi = RealisasiKirim::where("kontrak_m_id", "=", $id)->get();
            
            foreach ($opi as $opi) {
                $order = $order + $opi->jumlahOrder;
            }

            foreach ($realisasi as $data) {
                $kirim = $kirim + $data->qty_kirim;
            }
            
            if ($kirim > 0) { 
                $sisakirim = $kontrak->pcsKontrak - ($order - $kirim);
            } else {
                $sisakirim = 0;
            }

            $sisaopi = $kontrak->pcsKontrak - $order;

            // dd($sisakirim);

            if ($sisakirim > 0) {
                $sisakontrak = $sisakirim;
            } else if ($sisaopi){
                $sisakontrak = $sisaopi;
            } else {
                $sisakontrak = 0;
                $kontrakm->save();
            }

            $kontrak->pcsSisaKontrak = $sisakontrak;

            $kontrak->save();
            
            return redirect()->to(url()->previous())->with('success', 'Berhasil Recall QTY Kontrak');
        }

        public function empty_opi() {
            $data = Kontrak_D::leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->select('kontrak_m.kode','kontrak_d.*', 'kontrak_m.status')
            ->whereColumn('pcsKontrak', '=', 'pcsSisaKontrak')
            ->where('kontrak_m.status', '=', 4)
            ->get();

            dd($data);

        }
    }