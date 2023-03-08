<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Mastercard;
use App\Models\Opi_M;
use App\Models\RealisasiKirim;
use Carbon\Carbon;
// use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

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
                ->offset($start)
                ->limit(50)
                ->orderBy('id', 'desc')
                ->get();
                
                $totalFiltered = Kontrak_M::where('kode','LIKE',"%{$search}%")
                ->orWhere('customer_name', 'LIKE',"%{$search}%")
                ->orWhere('poCustomer', 'LIKE',"%{$search}%")
                ->count();
                // dd($opi);
            }
            
            $data = array();
            if (!empty($kontrak)) {
                foreach ($kontrak as $kontrak)
                {
                    $show =  route('kontrak.pdfb1',$kontrak->id);

                    if ($kontrak->status == 4) {
                        $edit =  null;
                    } else {  
                        $edit =  route('kontrak.edit',$kontrak->id);
                    }

                    $cancel = route('kontrak.cancel', $kontrak->id);
                    $dt =  route('kontrak.dt',$kontrak->id);
                    $kirim =  route('kontrak.realisasi',$kontrak->id);

                    if($kontrak->status == 2){
                        $nestedData['id'] = "<p style='color:red'>".$kontrak->id."</p>";
                        $nestedData['kontrak'] = "<p style='color:red'>".$kontrak->kode."</p>";
                        $nestedData['cust'] = "<p style='color:red'>".$kontrak->customer_name."</p>";
                        $nestedData['tglKontrak'] = "<p style='color:red'>".$kontrak->tglKontrak."</p>";
                        $nestedData['alamatKirim'] = "<p style='color:red'>".$kontrak->alamatKirim."</p>";
                        $nestedData['custTelp'] = "<p style='color:red'>".$kontrak->custTelp."</p>";
                        $nestedData['poCustomer'] = "<p style='color:red'>".$kontrak->poCustomer."</p>";
                        $nestedData['top'] = "<p style='color:red'>".$kontrak->top."</p>";
                        $nestedData['sales'] = "<p style='color:red'>".$kontrak->sales."</p>";
                        $nestedData['tipeOrder'] = "<p style='color:red'>".$kontrak->tipeOrder."</p>";
                        $nestedData['keterangan'] = "<p style='color:red'>".$kontrak->keterangan."</p>";
                        
                        // Realisasi Kirim
                        $terkirim = 0;
                        $dataRealisasi = [];
                        foreach ($kontrak->realisasi as $realisasi) {
                            
                            $dataRealisasi[] = 
                            "&emsp;<li><span class='glyphicon glyphicon-list'>".$realisasi->qty_kirim." ( ".date('d F', strtotime($realisasi->tanggal_kirim)).")</span></li>";
                            
                            $terkirim = $terkirim + $realisasi->qty_kirim;
                        }
                        
                        if (Auth::user()->divisi_id == 2) {
                            $nestedData['komisi'] = "<p style='color:red'>".$kontrak->komisi."</p>";
                        } else {
                            $nestedData['komisi'] = "<p style='color:red'>0</p>";
                        }
                        
                        $nestedData['realisasi'] = $dataRealisasi;
                        $nestedData['pcsKontrak'] = "<p style='color:red'>".number_format($kontrak->kontrak_d['pcsKontrak'],0,",",".")."</p>";
                        $nestedData['kgKontrak'] = "<p style='color:red'>".number_format($kontrak->kontrak_d['kgKontrak'],2,",",".")."</p>";
                        
                        $sisakontrak = number_format($kontrak->kontrak_d['pcsKontrak'] - $terkirim,0,",",".");

                        $nestedData['sisaKirim'] = "<p style='color:red'>".number_format($sisakontrak,0,",",".")."</p>";
                        $nestedData['rp_pcs'] = "<p style='color:red'>".number_format($kontrak->kontrak_d['harga_pcs'],2,",",".")."</p>";
                        $nestedData['rp_kg'] = "<p style='color:red'>".number_format($kontrak->kontrak_d['harga_kg'],2,",",".")."</p>";
                        
                        $mc = Mastercard::find($kontrak->kontrak_d->mc_id);
                        // $mcKode = ($mc->revisi != '' ? $mc->kode.'-'.$mc->revisi : $mc->kode);
                        
                        if($mc->revisi == ''){
                            $mcKode = $mc->kode;
                        } else if ($mc->revisi == "R0"){
                            $mcKode = $mc->kode;
                        } else {
                            $mcKode = $mc->kode.'-'.$mc->revisi;
                        }
                        
                        $nestedData['nomc'] = "<p style='color:red'>".$mcKode."</p>";
                        $nestedData['kodeBarang'] = "<p style='color:red'>".$mc->kodeBarang."</p>";
                        $nestedData['namaBarang'] = "<p style='color:red'>".$mc->namaBarang."</p>";
                        $nestedData['action'] = "&emsp;<button><a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'>Print</span></a></button>
                        &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'>Edit</span></a>&emsp;<a href='{$dt}' title='SHOW' ><span class='glyphicon glyphicon-list'>DT</span></a>&emsp;<a href='{$kirim}' title='SHOW' ><span class='glyphicon glyphicon-list'>Kirim</span></a>&emsp;<a href='{$cancel}' title='SHOW' ><span class='glyphicon glyphicon-list'>Cancel</span></a>";
                        
                        $nestedData['b_expedisi'] = "<p style='color:red'>".$kontrak->biaya_exp."</p>";
                        $nestedData['b_glue'] = "<p style='color:red'>".$kontrak->biaya_glue."</p>";
                        $nestedData['b_wax'] = "<p style='color:red'>".$kontrak->biaya_wax."</p>";
                    } else {                    
                        $nestedData['id'] = $kontrak->id;
                        $nestedData['kontrak'] = $kontrak->kode;
                        $nestedData['cust'] = $kontrak->customer_name;
                        $nestedData['tglKontrak'] = $kontrak->tglKontrak;
                        $nestedData['alamatKirim'] = $kontrak->alamatKirim;
                        $nestedData['custTelp'] = $kontrak->custTelp;
                        $nestedData['poCustomer'] = $kontrak->poCustomer;
                        $nestedData['top'] = $kontrak->top;
                        $nestedData['sales'] = $kontrak->sales;
                        $nestedData['tipeOrder'] = $kontrak->tipeOrder;
                        $nestedData['keterangan'] = $kontrak->keterangan;
                        
                        // Realisasi Kirim
                        $terkirim = 0;
                        $dataRealisasi = [];
                        foreach ($kontrak->realisasi as $realisasi) {
                            
                            $dataRealisasi[] = 
                            "&emsp;<li><span class='glyphicon glyphicon-list'>".number_format($realisasi->qty_kirim,0,",",".")." ( ".date('d F', strtotime($realisasi->tanggal_kirim)).")</span></li>";
                            
                            $terkirim = $terkirim + $realisasi->qty_kirim;
                        }
                        
                        if (Auth::user()->divisi_id == 2) {
                            $nestedData['komisi'] = $kontrak->komisi;
                        } else {
                            $nestedData['komisi'] = 0;
                        }
                        
                        $nestedData['realisasi'] = $dataRealisasi;
                        $nestedData['pcsKontrak'] = number_format($kontrak->kontrak_d['pcsKontrak'],0,",",".");
                        $nestedData['kgKontrak'] = number_format($kontrak->kontrak_d['kgKontrak'],2,",",".");
                        
                        $nestedData['sisaKirim'] = number_format($kontrak->kontrak_d['pcsKontrak'] - $terkirim,0,",",".");
                        $nestedData['rp_pcs'] = number_format($kontrak->kontrak_d['harga_pcs'],2,",",".");
                        $nestedData['rp_kg'] = number_format($kontrak->kontrak_d['harga_kg'],2,",",".");
                        
                        $mc = Mastercard::find($kontrak->kontrak_d->mc_id);
                        // $mcKode = ($mc->revisi != '' ? $mc->kode.'-'.$mc->revisi : $mc->kode);
                        
                        if($mc->revisi == ''){
                            $mcKode = $mc->kode;
                        } else if ($mc->revisi == "R0"){
                            $mcKode = $mc->kode;
                        } else {
                            $mcKode = $mc->kode.'-'.$mc->revisi;
                        }
                        
                        $nestedData['nomc'] = $mcKode;
                        $nestedData['kodeBarang'] = $mc->kodeBarang;
                        $nestedData['namaBarang'] = $mc->namaBarang;
                        $nestedData['action'] = "&emsp;<button><a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'>Print</span></a></button>
                        &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'>Edit</span></a>&emsp;<a href='{$dt}' title='SHOW' ><span class='glyphicon glyphicon-list'>DT</span></a>&emsp;<a href='{$kirim}' title='SHOW' ><span class='glyphicon glyphicon-list'>Kirim</span></a>&emsp;<a href='{$cancel}' title='SHOW' ><span class='glyphicon glyphicon-list'>Cancel</span></a>";
                        
                        $nestedData['b_expedisi'] = $kontrak->biaya_exp;
                        $nestedData['b_glue'] = $kontrak->biaya_glue;
                        $nestedData['b_wax'] = $kontrak->biaya_wax;
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
            
            // dd($json_data);
            echo json_encode($json_data); 
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
            $sales = DB::table('sales_m')->get();
            
            // menampilkan halaman form input dengan passing data dari query diatas
            
            // $tgl1 = '17-02-2021 12:00:00';
            // $tgl2 = '20-02-2021 12:30:00';
            
            // $selisih = (strtotime($tgl2) -  strtotime($tgl1))/60;
            // // $hari = $selisih/(60*60*24);
            // var_dump($selisih);
            
            return view('admin.kontrak.create', compact(
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
                $count = count($result)+1;
                if ($nobukti === $nobukti) {
                    $nobukti = str_replace('~YYYY~', date('Y', strtotime($start)), $nobukti);
                    $nobukti = str_replace('~MM~', date('m', strtotime($start)), $nobukti);                
                    $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
                }
            }
            
            
            // // dd($nobukti);
            
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
            for ($i=1; $i < 6; $i++) { 
                if ($request->idmcpel[$i] !== null) {
                    $kontrakd = Kontrak_D::create([
                        'kontrak_m_id' => $kontrakm->id,
                        'mc_id' => $request->idmcpel[$i],
                        'pcsKontrak' => $request->qtyPcs[$i],
                        // + $request->pcsToleransiLebih[$i] + $request->kgToleransiLebih[$i]
                        'pcsSisaKontrak' => $request->qtyPcs[$i],
                        'kgKontrak' => $request->qtyKg[$i],
                        'kgSisaKontrak' => $request->qtyKg[$i],
                        'pctToleransiLebihKontrak' => $request->toleransiLebih[$i],
                        'pctToleransiKurangKontrak' => $request->toleransiKurang[$i],
                        'pcsLebihToleransiKontrak' => $request->pcsToleransiLebih[$i],
                        'kgLebihToleransiKontrak' => $request->kgToleransiLebih[$i],
                        'pcsKurangToleransiKontrak' => $request->pcsToleransiKurang[$i],
                        'kgKurangToleransiKontrak' => $request->kgToleransiKurang[$i],
                        'harga_pcs' => $request->harga[$i],
                        'tax' => $request->tax[$i],
                        'amountBeforeTax' => $request->totalSblTax[$i],
                        'ppn' => $request->hargaTax[$i],
                        'amountTotal' => $request->Total[$i],
                        'harga_kg' => $request->hargaKg[$i],
                        'createdBy' => $request->createdBy,
                    ]);
                    
                    $tax = $tax + $request->hargaTax[$i];
                    $sblTax = $sblTax + $request->totalSblTax[$i];
                    $total = $total + $request->Total[$i];
                    // dd($tax);
                }
            }
            
            $upMaster = Kontrak_M::find($kontrakm->id); // finding row sesuai id untuk update ke table
            
            $upMaster->amountBeforeTax = $sblTax; // update database field amountBefireTax dengan value sblTax
            $upMaster->tax = $tax;
            $upMaster->amountTotal = $total;
            
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
            $sales = DB::table('sales_m')->get();
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
            $alphabet = 'C';
            $tahun = '2023';
            
            if ($request->tglKirim != null) {
                $lastOpi = Opi_M::where('periode', '=', $tahun) 
                            ->first();
                
                if($lastOpi == null){
                    $numb_opi = '0001'.$alphabet;
                    // dd($numb_opi);
                } else {
                    $lastOpi = Opi_M::where('periode', '=', $tahun)->get();
                    $numb_opi = str_pad(count($lastOpi)+1,4, '0', STR_PAD_LEFT).$alphabet   ;
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
                                    'status_opi' => 'Butuh Approve',
                                    'createdBy' => Auth::user()->name,
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
                                ]);
                                
                                $kontrakd->pcsSisaKontrak = $kontrakd->pcsSisaKontrak - $request->jumlahKirim;
                                $kontrakd->kgSisaKontrak = ($kontrakd->kgSisaKontrak*$request->berat) - ($request->jumlahOrder*$request->berat);
                                $kontrakd->save();
                            }
                        } elseif($request->tipebox == 'DC') {
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
                                    'status_opi' => 'Butuh Approve',
                                    'createdBy' => Auth::user()->name,
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
            // dd($kontrakd);
            
            // var_dump($tax);
            
            $kontrakd->save();
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
            
            $kontrak_D = Kontrak_D::where('kontrak_m_id', '=', $id)->first();
            
            $opi = DB::table('opi_m')->where('kontrak_m_id', '=', $id)->get();
            $sj = DB::connection('firebird2')->table('TDetSJ')
            ->leftJoin('TSuratJalan', 'TDetSJ.NomerSJ', 'TSuratJalan.NomerSJ')
            ->select('TDetSJ.NomerSJ as nomer', 'TSuratJalan.Periode', 'TSuratJalan.NamaCust', 'TSuratJalan.NomerMOD')->first();
            
            $kontrak_M =Kontrak_M::where('kontrak_m.id', '=', $id)
            ->first();
            
            return view('admin.kontrak.data_realisasi', compact(
                'kontrak_D', 
                'kontrak_M', 
                'opi'
            ));
        }
        
        public function store_realisasi(Request $request)
        {
            RealisasiKirim::create([
                'kontrak_m_id'  => $request->idkontrakm,
                'tanggal_kirim' => $request->tglKirim,
                'qty_kirim'     => $request->jumlahKirim,
                'createdBy'     => Auth::user()->name
            ]);
            
            return redirect('admin/kontrak');
        }
        
        public function edit_realisasi(Request $request, $id)
        {
            $kirim = RealisasiKirim::findOrFail($id);
            
            $kirim->update([
                'tanggal_kirim' => $request->tglKirim,
                'qty_kirim' => $request->jumlahKirim
            ]);
            
            return redirect()->to(url()->previous())->with('success', 'Berhasil Disimpan');
            
        }

        public function cancel_kontrak($id)
        {
            $kontrak = Kontrak_M::find($id);
            $kontrak->status = 2;

            $kontrak->save();
            return redirect('admin/kontrak')->with('success', 'Kontrak Berhasil di Cancel');
        }
    }