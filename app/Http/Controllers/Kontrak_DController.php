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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KontrakExport;
use App\Models\Accounting\Piutang;
use App\Models\AlokasiKaret;
use App\Models\Customer;
use App\Models\Karet;
use App\Models\Number_Sequence;
use Illuminate\Support\Facades\Log;

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

        public function index_new(Request $request)
        {
            $contractsQuery = new Kontrak_D;
            $contractsQuery = $contractsQuery->with('kontrakm', 'mc');
            
            if ($request->search) {
                $contractsQuery->WhereHas('kontrakm', function($query) use ($request) {
                    $query->where('kode', 'like', '%'.$request->search.'%')
                        ->orWhere('customer_name', 'like', '%'.$request->search.'%')
                        ->orWhere('poCustomer', 'like', '%'.$request->search.'%')
                        ->orWhere('sales', 'like', '%'.$request->search.'%');
                })
                ->orWhereHas('mc', function($query) use ($request) {
                    $query->where('kode', 'like', '%'.$request->search.'%')
                        ->orWhere('namaBarang', 'like', '%'.$request->search.'%');
                });
            }

            $contracts = $contractsQuery->orderBy('id', 'desc')->paginate(20);

            // dd($contracts);

            $data = [
                'contracts' => $contracts,
            ];
            
            return view('admin.kontrak.indexnew', $data);
        }
        
        /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function create()
        {
            
            // $cust = DB::connection('firebird')->table('TCustomer')->get();
            // $cust = DB::table('TCustomer')->get();
            // $mc = DB::table('mc')
            // ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            // ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            // ->leftJoin('box', 'box_id', '=', 'box.id')
            // ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease', 'box.namaBarang as box')
            // ->where('mc.status', '=', '1')
            // ->get();
            $top = DB::table('top')->get();
            $sales = DB::table('sales_m')
            ->where('aktif', '=', 1)
            ->orderBy('nama', 'Asc')
            ->get();
            
            return view('admin.kontrak.newcreate', compact(
                // 'mc', 
                'top', 
                // 'cust', 
                'sales'
            ));
        }

        public function customer_select(Request $request)
        {
            try {
                // Try using Customer model first
                $query = Customer::query();

                if ($request->has('search') && !empty($request->search)) {
                    $search = trim($request->search);
                    $query = $query->where(function($q) use ($search) {
                        $q->where('Nama', 'LIKE', '%'.$search.'%')
                          ->orWhere('Kode', 'LIKE', '%'.$search.'%')
                          ->orWhere('AlamatKirim', 'LIKE', '%'.$search.'%');
                    });
                }

                $cust = $query->orderBy('Nama', 'asc')->paginate(10);

            } catch (\Exception $e) {
                Log::error('Customer model error: ' . $e->getMessage());
                
                // Fallback to DB facade
                try {
                    $query = DB::connection('firebird')->table('TCustomer');
                    
                    if ($request->has('search') && !empty($request->search)) {
                        $search = trim($request->search);
                        $query = $query->where(function($q) use ($search) {
                            $q->where('Nama', 'LIKE', '%'.$search.'%')
                              ->orWhere('Kode', 'LIKE', '%'.$search.'%')
                              ->orWhere('AlamatKirim', 'LIKE', '%'.$search.'%');
                        });
                    }

                    $customers = $query->orderBy('Nama', 'asc')->paginate(10);
                    
                    // Convert to collection for consistency
                    $cust = $customers;
                    
                } catch (\Exception $e2) {
                    Log::error('Database connection error: ' . $e2->getMessage());
                    
                    // Return empty paginated collection
                    $cust = new \Illuminate\Pagination\LengthAwarePaginator(
                        collect([]),
                        0,
                        10,
                        1,
                        ['path' => request()->url(), 'pageName' => 'page']
                    );
                }
            }

            $data = [
                'cust' => $cust,
            ];
            
            return view('admin.customer.modal', $data);
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
                'min_tgl_kirim' => $request->tglkirim,
                'harga_expedisi' => $request->asumsi_exp ?? 0,
                'harga_karet' => $request->asumsi_harga_karet ?? 0,
                'harga_pisau' => $request->asumsi_harga_pisau ?? 0
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
                'pcsSisaKirim' => $request->qtyPcs,
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
            
            return redirect('admin/kontraknew')->with('success', "Data Berhasil disimpan dengan kode Kontrak = ". $nobukti);
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
            // $cust = DB::connection('firebird')->table('TCustomer')->get();
            
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
            
            if($kontrak_M->status == 2){
                return view('admin.kontrak.edit', compact(
                    // 'cust',
                    'mc',
                    'top',
                    'sales',
                    'kontrak_D'
                ), ['kontrak_M' => $kontrak_M]);
            } else if(Auth::user()->divisi_id == 2){
                return view('admin.kontrak.edit', compact(
                    // 'cust',
                    'mc',
                    'top',
                    'sales',
                    'kontrak_D'
                ), ['kontrak_M' => $kontrak_M]);
            } else {
                return redirect('admin/kontraknew');
            } 
        }
        
        public function add_dt($id)
        {
            try {
                // OPTIMIZED: Load only essential data with required relations for view
                $kontrak = Kontrak_D::select(['id', 'kontrak_m_id', 'mc_id', 'pcsKontrak', 'pcsSisaKontrak', 'kgKontrak'])
                    ->with([
                        'kontrakm:id,kode,customer_name,poCustomer,alamatKirim,tipeOrder',
                        'mc:id,kode,revisi,namaBarang,gramSheetBoxKontrak2,gramSheetBoxProduksi2,substanceKontrak_id,substanceProduksi_id,outConv,lebarSheet,panjangSheet',
                        'mc.substancekontrak:id,kode',
                        'mc.substanceproduksi:id,kode'
                    ])
                    ->where('kontrak_m_id', $id)
                    ->first();

                if (!$kontrak) {
                    return redirect()->back()->with('error', 'Kontrak tidak ditemukan');
                }

                // Ensure MC data exists
                if (!$kontrak->mc) {
                    return redirect()->back()->with('error', 'Data Mastercard tidak ditemukan untuk kontrak ini');
                }

                // OPTIMIZED: Get OPI data with minimal fields
                $opi = Opi_M::select(['id', 'NoOPI', 'jumlahOrder', 'dt_id', 'status_opi'])
                    ->with('dt:id,tglKirimDt,keterangan')
                    ->where('kontrak_m_id', $id)
                    ->orderBy('id', 'desc')
                    ->get();

                // Set safe defaults to prevent division by zero
                if ($kontrak->mc) {
                    $kontrak->mc->outConv = $kontrak->mc->outConv ?: 1;
                    $kontrak->mc->lebarSheet = $kontrak->mc->lebarSheet ?: 1;
                    $kontrak->mc->gramSheetBoxKontrak2 = $kontrak->mc->gramSheetBoxKontrak2 ?: 0;
                }

                return view('admin.kontrak.data_dtnew', [
                    'kontrak' => $kontrak,
                    'opi' => $opi,
                ]);
                
            } catch (\Exception $e) {
                Log::error('Error in add_dt: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data kontrak.');
            }
        }
        
        public function store_dt(Request $request)
        {

            // Validate required fields first
            if (empty($request->tglKirim)) {
                return redirect()->back()->with('error', 'Tanggal kirim harus diisi');
            }

            // OPTIMIZED: Cache commonly used values and reduce date operations
            $tglKirim = $request->tglKirim;
            $day = date("D", strtotime($tglKirim));
            $tahun = date('Y', strtotime($tglKirim));
            $userName = Auth::user()->name;
            $jumlahKirim = (int) $request->jumlahKirim;
            $berat = (float) ($request->berat ?? 1);
            
            

            // DB::beginTransaction();
            // try {
                // OPTIMIZED: Get all required data in fewer queries
                $nomer_opi = Number_Sequence::where('noBukti', 'nomer_opi')->first();
                $paddedNumber = str_pad($nomer_opi->nomer, 5, '0', STR_PAD_LEFT);
                $numb_opi = "{$paddedNumber}{$nomer_opi->format}";

                // OPTIMIZED: Check OPI existence early
                if (Opi_M::where('nama', $numb_opi)->exists()) {
                    return redirect()->back()->with('error', 'OPI ' . $numb_opi . ' sudah ada');
                }

                // OPTIMIZED: Single query for customer data
                $customerData = DB::connection('firebird')->table('TCustomer')
                    ->select('WAKTUBAYAR', 'Plafond', 'Kode')
                    ->where('Nama', $request->cust)
                    ->first();

                // OPTIMIZED: Calculate piutang total correctly with cross-database relation
                $piutang = Piutang::where('KodeCust', $customerData->Kode)
                    ->where('Note', 'JUAL')  // Hanya Note JUAL
                    ->whereRaw("(CASE WHEN Note = 'RETUR' THEN (TotalRp + TotalTerima) ELSE (TotalRp - TotalTerima) END) != 0")
                    ->selectRaw("
                        SUM(TotalRp - TotalTerima) as total_piutang,
                        SUM(TotalTerima) as total_terima,
                        MAX(DATEDIFF(DAY, TglJT, GETDATE())) as selisih_hari_max,
                        COUNT(*) as total_records
                    ")
                    ->first();
                
                $piutangData = Piutang::where('KodeCust', $customerData->Kode)
                    // ->whereRaw("DATEDIFF(DAY, TglJT, GETDATE()) > 30") // Filter data yang sudah lewat jatuh tempo + 30 hari
                    ->selectRaw("
                        SUM(CASE WHEN Note = 'RETUR' THEN TotalRp * -1 ELSE TotalRp END) as total_piutang,
                        SUM(TotalTerima) as total_terima,
                        MAX(DATEDIFF(DAY, TglJT, GETDATE())) as selisih_hari_max
                    ")
                    ->first();

                    
                    $piutangTotal = ($piutangData->total_piutang ?? 0) - ($piutangData->total_terima ?? 0);
                    // dd($customerData, $piutangTotal, $piutang);

                // OPTIMIZED: Get kontrak data in single query
                // $kontrakData = DB::table('kontrak_d as kd')
                //     ->join('kontrak_m as km', 'kd.kontrak_m_id', '=', 'km.id')
                //     ->select('kd.id as kontrak_d_id', 'kd.mc_id', 'kd.pcsSisaKontrak', 'kd.kgSisaKontrak', 'km.keterangan')
                //     ->where('kd.kontrak_m_id', $request->idkontrakm)
                //     ->first();

                $kontrakData = Kontrak_D::select('id as kontrak_d_id', 'mc_id', 'pcsSisaKontrak', 'kgSisaKontrak')
                    ->where('kontrak_m_id', $request->idkontrakm)
                    ->first();
                
                // dd($kontrakData);
                
                if (!$kontrakData) {
                    throw new \Exception('Data kontrak tidak ditemukan');
                }
                
                // OPTIMIZED: Prepare data for batch insert
                $currentTimestamp = now();
                
                // OPTIMIZED: Insert DeliveryTime
                $dtId = DB::table('dt')->insertGetId([
                    'kontrak_m_id' => $request->idkontrakm,
                    'opi' => $numb_opi,
                    'kodeKontrak' => $request->kode,
                    'tglKirimDt' => $tglKirim,
                    'pcsDt' => $jumlahKirim,
                    'createdBy' => $userName,
                    'keterangan' => $request->keterangan,
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp
                ]);
                
                // dd($dtId);
                // OPTIMIZED: Determine OPI status based on customer conditions
                $opiStatus = 'Proses'; // Default status

                if ($customerData->WAKTUBAYAR == 0 || $customerData->Plafond == 0) {
                    $opiStatus = 'Pending';
                } elseif ($piutangTotal > $customerData->Plafond) {
                    $opiStatus = 'Pending';
                } elseif (($piutang->selisih_hari_max ?? 0) > ($customerData->WAKTUBAYAR + 30)) {
                    $opiStatus = 'Pending';
                }

                // dd($opiStatus, $customerData, $piutangTotal, $piutang);
                

                // OPTIMIZED: Single OPI insert instead of multiple conditional inserts
                DB::table('opi_m')->insert([
                    'nama' => $numb_opi,
                    'periode' => $tahun,
                    'NoOPI' => $numb_opi,
                    'dt_id' => $dtId,
                    'mc_id' => $kontrakData->mc_id,
                    'kontrak_m_id' => $request->idkontrakm,
                    'kontrak_d_id' => $kontrakData->kontrak_d_id,
                    'keterangan' => $kontrakData->keterangan,
                    'tglKirimDt' => $tglKirim,
                    'jumlahOrder' => $jumlahKirim,
                    'sisa_order' => $jumlahKirim,
                    'hariKirimDt' => $day,
                    'status_opi' => $opiStatus,
                    'createdBy' => $userName,
                    'os_corr' => $jumlahKirim,
                    'os_flx' => $jumlahKirim,
                    'os_fin' => $jumlahKirim,
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp
                ]);
                
                // OPTIMIZED: Calculate new values safely
                $newPcsSisa = max(0, $kontrakData->pcsSisaKontrak - $jumlahKirim);
                $newKgSisa = max(0, $kontrakData->kgSisaKontrak - ($jumlahKirim * $berat));

                // Update number sequence and kontrak
                $nomer_opi->nomer += 1;
                $nomer_opi->save();
                
                // OPTIMIZED: Batch updates
                DB::table('kontrak_d')
                    ->where('id', $kontrakData->kontrak_d_id)
                    ->update([
                        'pcsSisaKontrak' => $newPcsSisa,
                        'kgSisaKontrak' => $newKgSisa,
                        'updated_at' => $currentTimestamp
                    ]);
                
                // OPTIMIZED: Simple tracking insert
                DB::table('tracking')->insert([
                    'user' => $userName,
                    'event' => "Tambah OPI " . $numb_opi,
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp
                ]);
                
                // DB::commit();
                
                return redirect()->back()
                    ->with('success', 'Data DT dan OPI berhasil disimpan dengan Nomor OPI ' . $numb_opi);
                
            // } 
            // catch (\Exception $e) {
            //     DB::rollBack();
            //     Log::error('Error in store_dt: ' . $e->getMessage());
            //     return redirect()->back()
            //         ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            // }
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
            $kontrakm->harga_expedisi = $request->asumsi_exp ?? 0;
            $kontrakm->harga_karet = $request->asumsi_harga_karet ?? 0;
            $kontrakm->harga_pisau = $request->asumsi_harga_pisau ?? 0;
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
            return redirect('admin/kontraknew');
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
            ->select('TDetSJ.NomerSJ as nomer', 'TSuratJalan.Periode', 'TSuratJalan.NamaCust', 'TSuratJalan.NomerMOD', 'TDetSJ.Quantity', 'TSuratJalan.TglSJ', 'TSuratJalan.NoSeal')
            ->where('TSuratJalan.NamaCust', 'LIKE', $kontrak_M->customer_name)
            ->orWhere('TSuratJalan.NamaCust', 'LIKE', 'PT. SARANA PACKAGING AGRAPANA')
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
                
                if(strlen($request->opi) > 6){
                    $opis = explode(',', $request->opi);
                    $opi = Opi_M::where('nama', '=', $opis[$i])->first();
                } else {
                    $opi = Opi_M::where('nama', '=', $request->opi)->first();
                }
                $kontrak = Kontrak_D::where('kontrak_m_id', "=", $id[$i])->first();
                $kontrakm = Kontrak_M::where('id', '=', $id)->first();
                $qty = intval(str_replace(',','',$request->jumlahKirim));
                $mc = Mastercard::where('id', "=", $kontrak->mc_id)->first();

                $karet = Karet::where('mc_id', '=', $kontrak->mc_id)
                                ->orderBy('id', 'desc')
                                ->first();

                RealisasiKirim::create([
                    'kontrak_m_id'  => $id[$i],
                    'opi_id'        => $opi ? $opi->id : '',
                    'tanggal_kirim' => $request->tglKirim,
                    'nomer_sj'      => $request->sj,
                    'mod'           => $request->mod,
                    'qty_kirim'     => $qty,
                    'kg_kirim'      => $qty * $mc->gramSheetBoxKontrak,
                    'createdBy'     => Auth::user()->name
                ]);

                if ($karet) {
                    $alokasi_karet = new AlokasiKaret();

                    $alokasi_karet->karet_id = $karet->id;
                    $alokasi_karet->mc_id = $kontrak->mc_id;
                    $alokasi_karet->tanggal_kirim = $request->tglKirim;
                    $alokasi_karet->pcs = $qty;
                    $alokasi_karet->alokasi_harga = $karet->gsm * $karet->alokasi * $qty;

                    $alokasi_karet->save();

                    $karet->sisa = $karet->sisa - $alokasi_karet->alokasi_harga;
                    $karet->save();
                }

                $kontrak->pcsSisaKirim = $kontrak->pcsSisaKontrak - $qty ;
                $kontrak->save();
                
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
            
            return redirect('admin/kontraknew');
        }
        
        public function edit_realisasi(Request $request, $id)
        {
            $kirim = RealisasiKirim::findOrFail($id);

            $kontrak = Kontrak_D::where('kontrak_m_id', "=", $kirim->kontrak_m_id)->first();
            $kontrakm = Kontrak_M::where('id', '=', $kontrak->kontrak_m_id)->first();
            $mc = Mastercard::where('id', "=", $kontrak->mc_id)->first();   
            
            // dd($kirim->qty_kirim);
            $kontrak->pcsSisaKirim = $kontrak->pcsSisaKirim + $kirim->qty_kirim - $request->jumlahKirim;
            $kontrak->save();
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
            return redirect('admin/kontraknew')->with('success', 'Kontrak Berhasil di Cancel');
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

            $sisaopi = $kontrak->pcsKontrak - $order;
            $sisakirim = $kontrak->pcsKontrak - $kirim;

            if ($sisaopi < 1) {
                $sisaopi = 0;
            }

            $kontrak->pcsSisaKontrak = $sisakirim;
            $kontrak->pcsSisaKirim = $sisakirim;

            $kontrak->save();
            
            return redirect()->back()->with('success', 'Berhasil Recall QTY Kontrak');
        }

        public function empty_opi() {
            $data = Kontrak_D::leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->select('kontrak_m.kode','kontrak_d.*', 'kontrak_m.status')
            ->whereColumn('pcsKontrak', '=', 'pcsSisaKontrak')
            ->where('kontrak_m.status', '=', 4)
            ->get();

            dd($data);

        }

        // public function exportExcel(Request $request)
        // {
        //     return Excel::download(new KontrakExport($request->search), 'kontrak.xlsx');
        // }

        /**
         * Export kontrak data to Excel
         *
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
         */
        public function exportExcel(Request $request)
        {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $search = $request->input('search');
            
            // Validasi tanggal jika ada
            if ($startDate && $endDate) {
                if (strtotime($startDate) > strtotime($endDate)) {
                    return redirect()->back()->with('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                }
            }
            
            // Generate filename dengan timestamp dan parameter
            $filename = 'export_kontrak_';
            if ($search) {
                $filename .= 'search_' . str_replace(' ', '_', $search) . '_';
            }
            if ($startDate && $endDate) {
                $filename .= $startDate . '_to_' . $endDate . '_';
            }
            $filename .= date('Y-m-d_H-i-s') . '.xlsx';
            
            // Download Excel file
            return Excel::download(new KontrakExport($startDate, $endDate, $search), $filename);
        }

        public function get_all_kontrak(Request $request)
        {
            $search = $request->search ?? $request->search;

            $contracts = new Kontrak_M();

            if ($search) {
                $contracts = $contracts->where(function($q) use ($search) {
                    $q->where('kode', 'LIKE', "%{$search}%")
                      ->orWhere('customer_name', 'LIKE', "%{$search}%");
                });
            }

            $contracts = $contracts->orderBy('id', 'desc')->paginate();

            $data = [
                'contracts' => $contracts,
            ];

            return view('admin.notif.kontrak_modal', $data);
        }

        public function single($id)
        {
            $contracts = Kontrak_M::find($id);
            return response()->json($contracts);
        }
    }