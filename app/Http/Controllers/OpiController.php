<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use App\Models\Opi_M;
use App\Models\Tracking;
use App\Exports\PlanKirimExport;
use App\Exports\IntakeMonthlyExport;
use App\Models\DeliveryTime;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\TightBlockInterface;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\FuncCall;

class OpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        $columns = array(
            0=>'id', 1=>'NoOPI',2=>'action',3=>'kode', 4=>'created_at',5=>'tglKirimDt',6=>'pcsDt',7=>'Cust', 8=>'namaBarang',9=>'jumlahOrder',10=>'sisa_order', 11=>'keterangan', 12=>'NoOPI',
            13=>'poCustomer', 14=>'mcKode',15=>'hariKirimDt',16=>'flute',17=>'tipeBox',18=>'panjangSheet',19=>'lebarSheet',20=>'outConv',21=>'Ukroll',22=>'tipeOrder',23=>'namacc',24=>'joint',25=>'KertasAtas',26=>'KAtas',27=>'Kbf',28=>'KTengah',29=>'Kcf',30=>'KBawah',31=>'KertasBawah',32=>'wax',33=>'gram',34=>'tglKontrak',35=>'alamatKirim',36=>'toleransi',37=>'panjang',38=>'lebar',39=>'tinggi',40=>'koli',41=>'tglKirimDt',42=>'harga_kg',43=>'realisasiKirim',44=>'sisaDt',45=>'status',46=>'noKontrak',47=>'tglKontrak',48=>'KertasKAtas', 49=>'KAtasP', 50=>'KbfP', 51=>'KTengahP', 52=>'KcfP',53=>'KBawahP', 54=>'KertasBawahP', 55=>'null',54=>'kodeBarang',56=>'tipeCreasCorr',57=>'bungkus',58=>'lain'
        );

        $totalData = Opi_M::opi()->count();
        $limit = $request->input('length');
        $start = $request->input('start');

        // dd($start, $limit);
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
           if (Auth::user()->divisi_id == 5) {
                $opi = Opi_M::opi()->where('NoOPI', 'NOT LIKE', "%CANCEL%")
                ->where('status_opi', '=', "Proses")
                ->where('periode', '=', '2025')
                ->offset($start)
                ->limit(50)
                ->orderBy('NoOPI')
                ->get();
                
                $totalFiltered = Opi_M::opi()->count();
           } else {
                $opi = Opi_M::opi()->offset($start)
                ->limit(50)
                ->orderBy('NoOPI')
                ->get();
                
                $totalFiltered = Opi_M::opi()->count();
           }
        }
        else {
            $search = $request->input('search.value'); 

            if (Auth::user()->divisi_id == 5) {
                $opi =  Opi_M::opi()->where('NoOPI', 'NOT LIKE', "%CANCEL%")
                            ->where('status_opi', '=', "Proses")
                            ->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.poCustomer', 'LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.kode', 'LIKE',"%{$search}%")
                            ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                            ->orWhere('mc.kode', 'LIKE',"%{$search}%")
                            ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit(50)
                            ->orderBy($order, $dir)
                            ->get();

                $totalFiltered = Opi_M::opi()->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                             ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                             ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                             ->count();
            } else {
                $opi =  Opi_M::opi()->where('NoOPI', 'NOT LIKE', "%CANCEL%")
                            ->where('status_opi', 'NOT LIKE', "closed")
                            ->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.kode', 'LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.poCustomer', 'LIKE',"%{$search}%")
                            ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                            ->orWhere('mc.kode', 'LIKE',"%{$search}%")
                            ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit(50)
                            ->orderBy($order, $dir)
                            ->get();

                $totalFiltered = Opi_M::opi()->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                             ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                             ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                             ->count();
            }
        }

        // dd($opi);
        $data = array();
        if(!empty($opi))
        {
            foreach ($opi as $opi)
            {
                $show =  route('opi.print',$opi->id);
                $edit =  route('opi.edit',$opi->id);
                $cancel = route('opi.cancel', $opi->id);
                $closed = route('opi.closed', $opi->id);

                $cek_opi = strpos($opi->nama,"CANCEL");

                $nestedData['id'] = $opi->id;
                $nestedData['NoOPI'] = $opi->NoOPI;

                if ($cek_opi == '') { 
                    if (Auth::user()->divisi_id == 3 || Auth::user()->divisi_id == 2) {
                           
                        $nestedData['action'] = "
                        <a href='{$closed}' title='Closed' class='btn btn-outline-warning' type='button'><i class='fa fa-lock' data-toggle='tooltip' data-placement='bottom' title='' id=''></i></a>
                        <a href='{$cancel}' title='Cancel' class='btn btn-outline-danger' type='button'><i class='fa fa-ban' data-toggle='tooltip' data-placement='bottom' title='' id=''></i></a>
                        <a href='{$show}' title='SHOW' class='btn btn-outline-success' type='button'><i class='fa fa-print' data-toggle='tooltip' data-placement='bottom' title='Print' id='Print'></i></a>
                        ";
                    } else {
                        $nestedData['action'] = "<a href='{$show}' title='SHOW' class='btn btn-outline-success' type='button'><i class='fa fa-eye' data-toggle='tooltip' data-placement='bottom' title='Print' id='Print'></i></a>
                        ";
                    }
                } else {
                
                    $nestedData['action'] = "<a href='{$show}' title='SHOW' class='btn btn-outline-success' type='button'><i class='fa fa-eye' data-toggle='tooltip' data-placement='bottom' title='Print' id='Print'></i></a>
                    ";
                }
                $nestedData['kode'] = $opi->kode;
                $nestedData['created_at'] = date('j M Y H:i:s',strtotime($opi->created_at));

                if ($opi->dt_perubahan !== '') {
                    if ($opi->approve_mkt == 1 && $opi->approve_ppic == 1) {
                        $dt = $opi->dt_perubahan;
                    } else {
                        $dt = $opi->tglKirimDt;
                    }
                } else {
                    $dt = $opi->tglKirimDt;
                }

                $nestedData['tglKirimDt'] = $dt;

                $nestedData['pcsDt'] = $opi->pcsDt;
                $nestedData['Cust'] = $opi->Cust;
                $nestedData['namaBarang'] = $opi->namaBarang;
                $nestedData['jumlahOrder'] = $opi->jumlahOrder;
                $nestedData['sisa_order'] = $opi->sisa_order;
                $nestedData['keterangan'] = $opi->ketkontrak;
                $nestedData['NoOPI'] = $opi->NoOPI;
                $nestedData['poCustomer'] = $opi->poCustomer;

                if ($opi->revisi == '') {
                    $mc = $opi->mcKode;
                } else if ($opi->revisi == "R0") {
                    $mc = $opi->mcKode;
                } else {
                    $mc = $opi->mcKode.'-'.$opi->revisi;
                }
                // $mc = ($opi->revisi != '' ? $opi->mcKode.'-'.$opi->revisi : $opi->mcKode );

                $nestedData['nomc'] = $mc;

                $day = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU"];
                $hari = $day[date('w', strtotime($opi->tglKirimDt))];

                $nestedData['hari'] = $hari;
                $nestedData['flute'] = $opi->flute;
                $nestedData['tipeBox'] = $opi->tipeBox;
                $nestedData['panjangSheet'] = $opi->panjangSheet;
                $nestedData['lebarSheet'] = $opi->lebarSheet;
                $nestedData['outConv'] = $opi->outConv;
                $nestedData['Ukroll'] = "-";
                $nestedData['tipeOrder'] = $opi->tipeOrder;
                $nestedData['namacc'] = $opi->namacc;
                $nestedData['joint'] = $opi->joint;
                $nestedData['KertasAtas'] = ($opi->kertasMcAtas == "BK" ? "K" : $opi->kertasMcAtas);
                // $nestedData['KertasAtas'] = $opi->kertasMcAtas;
                $nestedData['gramKertasAtas'] = $opi->gramKertasAtas;
                $nestedData['gramKertasflute1'] = $opi->gramKertasflute1;
                $nestedData['gramKertastengah'] = $opi->gramKertastengah;
                $nestedData['gramKertasflute2'] = $opi->gramKertasflute2;
                $nestedData['gramKertasbawah'] = $opi->gramKertasbawah;
                $nestedData['kertasMcbawah'] = ($opi->kertasMcbawah == "BK" ? "K" : $opi->kertasMcbawah);
                // $nestedData['kertasMcbawah'] = $opi->kertasMcbawah;
                $nestedData['wax'] = $opi->wax;

                if (Auth::user()->divisi_id == 3) {
                    $nestedData['gram'] = $opi->gramKontrak;
                } else {
                    $nestedData['gram'] = $opi->gramProd;
                }

                $nestedData['tglKontrak'] = $opi->tglKontrak;
                $nestedData['alamatKirim'] = $opi->alamatKirim;
                $nestedData['toleransi'] = $opi->toleransiKurang.'%/'.$opi->toleransiLebih.'%';
                $nestedData['panjang'] = $opi->panjang;
                $nestedData['lebar'] = $opi->lebar;
                $nestedData['tinggi'] = $opi->tinggi;
                $nestedData['koli'] = $opi->koli;
                $nestedData['status'] = $opi->status;
                $nestedData['harga_kg'] = $opi->harga_kg;
                $nestedData['kertasMcAtasK'] = ($opi->kertasMcAtasK == "BK" ? "K" : $opi->kertasMcAtasK);
                $nestedData['gramKertasAtasK'] = $opi->gramKertasAtasK;
                $nestedData['gramKertasflute1K'] = $opi->gramKertasflute1K;
                $nestedData['gramKertastengahK'] = $opi->gramKertastengahK;
                $nestedData['gramKertasflute2K'] = $opi->gramKertasflute2K;
                $nestedData['gramKertasbawahK'] = $opi->gramKertasbawahK;
                $nestedData['kertasMcbawahK'] = ($opi->kertasMcbawahK == "BK" ? "K" : $opi->kertasMcbawahK);
                $nestedData['kodeBarang'] = $opi->kodeBarang;
                $nestedData['tipeCreasCorr'] = $opi->tipeCreasCorr;
                $nestedData['bungkus'] = $opi->bungkus;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        

        // dd($json_data);
        echo json_encode($json_data); 
     
        // $data = Opi_M::opi()->get();
        // return Datatables::of($data)->make(true);
    }

    public function approve_index(Request $request)
    {
        $opi = Opi_M::opi()->where('status_opi', '=', 'Pending')->get();
        if ($request->ajax()) {
            return DataTables::of($opi)
                    ->addColumn('checkbox', function($opi){ 
                        return '<input type="checkbox" class="rowCheckbox" value="'. $opi->id .'">';
                    })
                    ->addColumn('action', function($opi) {
                        return '<a href="/admin/ppic/opi/approve/'. $opi->id .'" class="btn btn-primary rounded">Edit</a>';
                    })
                    ->rawColumns(['checkbox','action'])
                    ->make(true);
                }
                // dd($opi);

        return view('admin.ppic.opi.data_approve_opi');
    }

    public function proses_approve($id)
    {
        $opi = Opi_M::findOrFail($id);

        $opi->status_opi = 'Proses';
        $opi->save();
        
        return redirect()->back()->with('success', 'OPI '.$opi->NoOPI.' sudah diapprive!!');
    }

    public function single($id)
    {
        $opis = Opi_M::with([
            'kontrakm', 
            'kontrakd', 
            'mc.substanceproduksi.lineratas',
            'mc.substanceproduksi.flute1', 
            'mc.substanceproduksi.linertengah',
            'mc.substanceproduksi.flute2',
            'mc.substanceproduksi.linerbawah',
            'dt'
        ])->findOrFail($id);
        
        return response()->json($opis);
    }

    public function jsonPaginated(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = 20;
            $search = $request->input('search', '');
            
            // Use simple query instead of heavy opi() scope to avoid connection reset
            $query = Opi_M::select([
                    'opi_m.id',
                    'opi_m.NoOPI', 
                    'opi_m.jumlahOrder',
                    'opi_m.status_opi',
                    'opi_m.tglKirimDt',
                    'kontrak_m.customer_name as Cust',
                    'kontrak_m.poCustomer',
                    'kontrak_m.kode as kontrakKode',
                    'mc.kode as mcKode',
                    'mc.namaBarang',
                    'mc.tipeBox',
                    'mc.flute',
                    'mc.panjangSheet',
                    'mc.lebarSheet', 
                    'mc.outConv',
                    'mc.gramSheetCorrProduksi as gramProd',
                    'mc.revisi'
                ])
                ->leftJoin('kontrak_d', 'opi_m.kontrak_d_id', '=', 'kontrak_d.id')
                ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', '=', 'kontrak_m.id')
                ->leftJoin('mc', 'kontrak_d.mc_id', '=', 'mc.id')
                ->where('opi_m.NoOPI', 'NOT LIKE', "%CANCEL%")
                ->where('opi_m.status_opi', '=', "Proses");
        
            // Apply search filter if provided
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('kontrak_m.customer_name', 'LIKE', "%{$search}%")
                      ->orWhere('kontrak_m.poCustomer', 'LIKE', "%{$search}%")
                      ->orWhere('kontrak_m.kode', 'LIKE', "%{$search}%")
                      ->orWhere('opi_m.NoOPI', 'LIKE', "%{$search}%")
                      ->orWhere('mc.kode', 'LIKE', "%{$search}%")
                      ->orWhere('mc.namaBarang', 'LIKE', "%{$search}%");
                });
            }
            
            // Get total count for pagination
            $totalRecords = $query->count();
            
            // Get paginated data
            $opis = $query->offset(($page - 1) * $perPage)
                         ->limit($perPage)
                         ->orderBy('opi_m.id', 'desc')
                         ->get();
            
            // Format data for response
            $data = [];
            foreach ($opis as $opi) {
                $nestedData = [];
                $nestedData['id'] = $opi->id;
                $nestedData['NoOPI'] = $opi->NoOPI;
                $nestedData['Cust'] = $opi->Cust;
                $nestedData['namaBarang'] = $opi->namaBarang;
                $nestedData['jumlahOrder'] = $opi->jumlahOrder;
                $nestedData['tipeBox'] = $opi->tipeBox;
                $nestedData['flute'] = $opi->flute;
                $nestedData['panjangSheet'] = $opi->panjangSheet;
                $nestedData['lebarSheet'] = $opi->lebarSheet;
                $nestedData['outConv'] = $opi->outConv;
                $nestedData['gram'] = $opi->gramProd;
                $nestedData['status_opi'] = $opi->status_opi;
                $nestedData['tglKirimDt'] = $opi->tglKirimDt;
                
                // Handle MC code with revision
                if ($opi->revisi == '' || $opi->revisi == "R0") {
                    $nestedData['kode'] = $opi->mcKode ?? 'N/A';
                } else {
                    $nestedData['kode'] = ($opi->mcKode ?? 'N/A') . '-' . $opi->revisi;
                }
                
                $data[] = $nestedData;
            }
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'pagination' => [
                    'current_page' => (int)$page,
                    'per_page' => $perPage,
                    'total' => $totalRecords,
                    'total_pages' => ceil($totalRecords / $perPage),
                    'from' => (($page - 1) * $perPage) + 1,
                    'to' => min($page * $perPage, $totalRecords)
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in OPI jsonPaginated: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data OPI: ' . $e->getMessage(),
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'per_page' => 20,
                    'total' => 0,
                    'total_pages' => 0,
                    'from' => 0,
                    'to' => 0
                ]
            ], 500);
        }
    }
    
    public function index(Request $request)
    {
        $data = Opi_M::opi()->limit(100)->get();
        return view('admin.opi.index', compact('data'));
    }

    public function index_new(Request $request)
    {
        $productions = new Opi_M();
        $productions = $productions->with('mc', 'dt', 'kontrakm', 'kontrakd')
            ->where('status_opi', 'Proses')
            // ->where('NoOPI', 'NOT LIKE', '%CANCEL%')
            ->orderBy('id', 'desc');

        if($request->search) {
            $productions->whereHas('kontrakm', function($query) use ($request) {
                $query->where('customer_name', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('poCustomer', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('kode', 'LIKE', '%' . $request->search . '%');
            })
            ->orWhere('NoOPI', 'LIKE', '%' . $request->search . '%')
            ->orWhereHas('mc', function($query) use ($request) {
                $query->where('kode', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('namaBarang', 'LIKE', '%' . $request->search . '%');
            });
        }

        $productions = $productions->paginate(50);

        $data = [
            'productions' => $productions,
        ];

        return view('admin.opi.indexnew', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $opi_m = DB::table('opi_m')->get();
        $alphabet = "B";
        $numb_opi = str_pad(count($opi_m)+3202+1,4, '0', STR_PAD_LEFT).$alphabet;


        $kontrak_d = DB::table('kontrak_d')
            ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('kontrak_d.*','kontrak_m.kode as noKontrak', 'kontrak_m.tglKontrak as tglOrder', 'kontrak_m.tipeOrder as tipeOrder', 'kontrak_m.poCustomer as poCust', 'kontrak_m.customer_name as namaCust', 'kontrak_m.alamatKirim as alamatKirim', 'kontrak_m.keterangan as keterangan', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'substance.namaMc as substance', 'mc.kode as nomc', 'mc.kodeBarang as kodeBarang', 'mc.namaBarang as namaBarang', 'mc.flute as flute', 'color_combine.nama as warna', 'mc.outConv as outConv', 'mc.gramSheetCorrKontrak as berat' , 'mc.koli as koli', 'mc.joint as joint', 'mc.tipeBox as bentuk', 'mc.id as mcid', 'kontrak_m.id as kontrakmid', 'mc.revisi as revisi'  )
            ->get();

        $dt = DB::table('dt')->get();

        return view('admin.opi.create', compact('kontrak_d', 'dt', 'numb_opi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $opi = Opi_M::find($id);
        $kontrakd = Kontrak_D::find($opi->kontrak_d_id);
                
        Tracking::create([
            'user' => Auth::user()->name,
            'event' => "Cancel Kontrak". $opi->NoOPI
        ]);

        $opi->nama = $opi->nama."(CANCEL)";
        $opi->NoOPI = $opi->NoOPI."(CANCEL)";
        $opi->lastUpdatedBy = Auth::user()->name;
        $opi->status_opi = "Cancel";
        
        $kontrakd->pcsSisaKontrak = $kontrakd->pcsSisaKontrak + $opi->jumlahOrder ;

        $opi->jumlahOrder = 0;

        $opi->save();
        $kontrakd->save();

        return redirect()->back()->with('success', 'OPI '.$opi->NoOPI.' sudah di cancel!!');
    }

    public function closed($id)
    {
        $opi = Opi_M::find($id);
        $kontrakd = Kontrak_D::find($opi->kontrak_d_id);

        // dd($opi);

        $opi->status_opi = "closed";
        $opi->lastUpdatedBy = Auth::user()->name;

        $opi->jumlahOrder = 0;

        $opi->save();
        // $kontrakd->save();

        return redirect('admin/opi');

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $opi = Opi_M::with(['kontrakm', 'kontrakd', 'mc', 'dt'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $opi->id,
                    'NoOPI' => $opi->NoOPI,
                    'jumlahOrder' => $opi->jumlahOrder,
                    'keterangan' => $opi->keterangan,
                    'tglKirimDt' => $opi->dt ? $opi->dt->tglKirimDt : null,
                    'pcsDt' => $opi->dt ? $opi->dt->pcsDt : null,
                    'dt_id' => $opi->dt_id,
                    'status_opi' => $opi->status_opi,
                    'customer_name' => $opi->kontrakm ? $opi->kontrakm->customer_name : null,
                    'namaBarang' => $opi->mc ? $opi->mc->namaBarang : null,
                    'keterangan' => $opi->dt ? $opi->dt->keterangan : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data OPI tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'jumlahOrder' => 'required|numeric|min:1',
                'keterangan' => 'nullable|string|max:255',
                'tglKirimDt' => 'required|date',
                'pcsDt' => 'required|numeric|min:1'
            ]);

            $opi = Opi_M::findOrFail($id);
            
            // Update OPI data
            $opi->jumlahOrder = $request->jumlahOrder;
            $opi->tglKirimDt = $request->tglKirimDt;
            $opi->lastUpdatedBy = Auth::user()->name;
            $opi->save();

            // Update DT data if exists
            if ($opi->dt_id && $opi->dt) {
                $dt = $opi->dt;
                $dt->tglKirimDt = $request->tglKirimDt;
                $dt->keterangan = $request->keterangan;
                $dt->lastUpdatedBy = Auth::user()->name;
                $dt->save();
            }

            // Track the change
            Tracking::create([
                'user' => Auth::user()->name,
                'event' => "Update OPI " . $opi->NoOPI
            ]);

            return redirect()->back()->with('success', 'Data OPI ' . $opi->NoOPI . ' berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data OPI: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {

        $opi2 = DB::table('opi_m')
        ->leftJoin('dt', 'dt_id', 'dt.id')
        ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('kontrak_d', 'kontrak_d_id', 'kontrak_d.id')
        ->leftJoin('mc', 'kontrak_d.mc_id', 'mc.id')
        ->leftJoin('box', 'mc.box_id', 'box.id')
        ->leftJoin('substance', 'mc.substanceProduksi_id', 'substance.id')
        ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
        ->where('opi_m.id', '=', $id)
        ->select('kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_d.pctToleransiKurangKontrak', 'kontrak_d.pctToleransiLebihKontrak', 'kontrak_m.tipeOrder', 'kontrak_m.keterangan as ketkontrak', 'opi_m.noOPI', 'opi_m.jumlahOrder', 'opi_m.keterangan', 'mc.namaBarang', 'opi_m.nama', 'mc.revisi', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'substance.kode as subsKode', 'mc.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxKontrak as gram', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt', 'mc.outConv', 'mc.id as mcid', 'mc.lebarSheet', 'mc.panjangSheet')
        ->first();

        // dd($opi2);

        return view('admin.opi.pdf', compact('opi2'));
    }

    public function plan_kirim(Request $request)
    {
        // Jika tidak ada parameter tanggal, hanya tampilkan form
        if (!$request->has('start') || !$request->has('end')) {
            return view('admin.opi.plan_kirim', [
                'data' => collect(), // Empty collection
                'start_date' => null,
                'end_date' => null
            ]);
        }

        // Validasi input tanggal
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        // Alternatif 1: Menggunakan subquery untuk ORDER BY
        $data = Opi_M::with([
                'mc', 
                'kontrakm', 
                'kontrakd', 
                'dt'
            ])
            ->whereBetween('tglKirimDt', [$request->start, $request->end])
            ->where('status_opi', 'Proses')
            ->orderByRaw('(SELECT kodeBarang FROM mc 
                          JOIN kontrak_d ON mc.id = kontrak_d.mc_id 
                          WHERE kontrak_d.id = opi_m.kontrak_d_id) ASC')
            ->get();

        // Ambil data stock dari Firebird database
        DB::connection('firebird2')->beginTransaction(); // Enable query log for debugging
            $stock = DB::connection('firebird2')->table('TPersediaan')
                ->select('KodeBrg', 'SaldoAkhirCrt as stock_quantity')
                ->where('Periode', '=', date('m/Y')) // Current month/year
                ->get();


        // Clean up data: trim spaces dan convert ke numeric
        $stock = $stock->map(function($item) {
            return (object) [
                'KodeBrg' => trim($item->KodeBrg), // Hapus spasi trailing
                'quantity' => floatval($item->stock_quantity) // Convert to numeric
            ];
        });


        // Convert stock data ke collection dengan KodeBrg sebagai key untuk mapping yang lebih efisien
        $stockMap = $stock->pluck('quantity', 'KodeBrg');
        
        // Debug: Lihat hasil clean data
        // dd('Cleaned stock:', $stock->take(3), 'Stock map:', $stockMap->take(3));

        // Map quantity dari stock ke data OPI berdasarkan kodeBarang
        $data = $data->map(function ($item) use ($stockMap) {
            // Ambil kode barang dari relasi mc
            $kodeBarang = $item->mc->kodeBarang ?? null;
            
            // Cari quantity di stock berdasarkan kode barang
            $quantity = $stockMap->get($kodeBarang, 0); // Default 0 jika tidak ditemukan
            
            // Tambahkan property stock_quantity ke item
            $item->stock_quantity = $quantity;
            
            // Hitung stock status (aman, kurang, habis)
            $needed = $item->jumlahOrder ?? 0;
            if ($quantity >= $needed) {
                $item->stock_status = 'aman';
                $item->stock_indicator = 'success';
            } elseif ($quantity > 0 && $quantity < $needed) {
                $item->stock_status = 'kurang';
                $item->stock_indicator = 'warning';
            } else {
                $item->stock_status = 'habis';
                $item->stock_indicator = 'danger';
            }
            
            // Hitung selisih stock vs kebutuhan
            $item->stock_difference = $quantity - $needed;
            
            return $item;
        });

        $start_date = date('d M Y', strtotime($request->start));
        $end_date = date('d M Y', strtotime($request->end));

        return view('admin.opi.plan_kirim', compact('data', 'start_date', 'end_date', 'stockMap'));
    }

    public function plan_kirim_export(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        // Ambil data OPI sesuai periode (sama seperti plan_kirim method)
        $data = Opi_M::with([
                'mc', 
                'kontrakm', 
                'kontrakd', 
                'dt'
            ])
            ->whereBetween('tglKirimDt', [$request->start, $request->end])
            ->where('status_opi', 'Proses')
            ->orderByRaw('(SELECT kodeBarang FROM mc 
                          JOIN kontrak_d ON mc.id = kontrak_d.mc_id 
                          WHERE kontrak_d.id = opi_m.kontrak_d_id) ASC')
            ->get();

        // Ambil data stock dari Firebird database
        DB::connection('firebird2')->beginTransaction(); // Enable query log for debugging
        $stock = DB::connection('firebird2')->table('TPersediaan')
            ->select('KodeBrg', 'SaldoAkhirCrt as stock_quantity')
            ->where('Periode', '=', date('m/Y'))
            ->get();

        // Clean up data dan mapping stock
        $stock = $stock->map(function($item) {
            return (object) [
                'KodeBrg' => trim($item->KodeBrg),
                'quantity' => floatval($item->stock_quantity)
            ];
        });

        $stockMap = $stock->pluck('quantity', 'KodeBrg');
        
        // Map quantity dari stock ke data OPI
        $data = $data->map(function ($item) use ($stockMap) {
            $kodeBarang = $item->mc->kodeBarang ?? null;
            $quantity = $stockMap->get($kodeBarang, 0);
            
            $item->stock_quantity = $quantity;
            
            $needed = $item->jumlahOrder ?? 0;
            if ($quantity >= $needed) {
                $item->stock_status = 'aman';
                $item->stock_indicator = 'success';
            } elseif ($quantity > 0 && $quantity < $needed) {
                $item->stock_status = 'kurang';
                $item->stock_indicator = 'warning';
            } else {
                $item->stock_status = 'habis';
                $item->stock_indicator = 'danger';
            }
            
            $item->stock_difference = $quantity - $needed;
            
            return $item;
        });

        // Format tanggal untuk filename dan display
        $start_date = date('d-M-Y', strtotime($request->start));
        $end_date = date('d-M-Y', strtotime($request->end));
        $filename = "Plan_Kirim_OPI_{$start_date}_to_{$end_date}.xlsx";

        // Export to Excel
        return Excel::download(new PlanKirimExport($data, $start_date, $end_date), $filename);
    }

    /**
     * Show intake monthly export page
     */
    public function intakeMonthly()
    {
        return view('admin.opi.intake_monthly');
    }

    /**
     * Export intake data per month
     */
    public function exportIntakeMonthly(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Validate month and year
        if (!is_numeric($month) || $month < 1 || $month > 12) {
            $month = date('m');
        }
        if (!is_numeric($year) || $year < 2020 || $year > date('Y') + 1) {
            $year = date('Y');
        }

        // Generate filename
        $monthName = date('F_Y', mktime(0, 0, 0, $month, 1, $year));
        $filename = "Intake_Data_{$monthName}.xlsx";

        // Export to Excel
        return Excel::download(new IntakeMonthlyExport($month, $year), $filename);
    }
}
