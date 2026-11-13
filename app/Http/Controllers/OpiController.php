<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use App\Models\Opi_M;
use App\Models\Tracking;
use App\Exports\PlanKirimExport;
use App\Models\PlanKirim;
use App\Models\PlanKirimItem;
use App\Exports\IntakeMonthlyExport;
use App\Models\DeliveryTime;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            $searchQuery = Opi_M::opi()
                ->where('opi_m.NoOPI', 'NOT LIKE', '%CANCEL%')
                ->whereNotIn('opi_m.status_opi', ['Pending', 'Cancel'])
                ->where(function ($query) use ($search) {
                    $query->where('kontrak_m.customer_name', 'LIKE', "%{$search}%")
                        ->orWhere('kontrak_m.poCustomer', 'LIKE', "%{$search}%")
                        ->orWhere('kontrak_m.kode', 'LIKE', "%{$search}%")
                        ->orWhere('opi_m.NoOPI', 'LIKE', "%{$search}%")
                        ->orWhere('mc.kode', 'LIKE', "%{$search}%")
                        ->orWhere('mc.namaBarang', 'LIKE', "%{$search}%");
                });

            $totalFiltered = (clone $searchQuery)->count('opi_m.id');
            $opi = $searchQuery
                ->offset($start)
                ->limit(50)
                ->orderBy($order, $dir)
                ->get();
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

                $dt = \App\Models\DeliveryTime::effectiveDate($opi->tglKirimDt, $opi->dt_perubahan, $opi->approve_ppic);

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
            $perPage = 10;
            $search = $request->input('search', '');
            $plan_corr = $request->input('plan_corr', null);

            // Convert string "0" to integer 0
            if ($plan_corr === "0") {
                $plan_corr = 0;
            }

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

            // Add plan_corr filter conditionally
            if ($plan_corr !== null) {
                $query->where('opi_m.plan_corr', '=', $plan_corr);
            } else {
                $query->whereNull('opi_m.plan_corr');
            }

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
            Log::error('Error in OPI jsonPaginated: ' . $e->getMessage());

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
        $status = 'Proses';
        $productions = $productions->with([
            'dt',
            'kontrakm',
            'kontrakd.mc',
            'mc.colorcombine',
            'mc.box',
            'mc.substanceproduksi.lineratas',
            'mc.substanceproduksi.flute1',
            'mc.substanceproduksi.linertengah',
            'mc.substanceproduksi.flute2',
            'mc.substanceproduksi.linerbawah',
            'mc.substancekontrak.lineratas',
            'mc.substancekontrak.flute1',
            'mc.substancekontrak.linertengah',
            'mc.substancekontrak.flute2',
            'mc.substancekontrak.linerbawah',
        ])
            ->whereNotIn('status_opi', ['Cancel', 'Pending'])
            // ->where('NoOPI', 'NOT LIKE', '%CANCEL%')
            ->orderBy('updated_at', 'desc')
            ->orderBy('NoOPI', 'desc');

        if($request->search) {
            $search = $request->search;

            $productions->where(function ($builder) use ($search) {
                $builder->whereHas('kontrakm', function($query) use ($search) {
                    $query->where('customer_name', 'LIKE', '%' . $search . '%')
                          ->orWhere('poCustomer', 'LIKE', '%' . $search . '%')
                          ->orWhere('kode', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('NoOPI', 'LIKE', '%' . $search . '%')
                ->orWhereHas('mc', function($query) use ($search) {
                    $query->where('kode', 'LIKE', '%' . $search . '%')
                          ->orWhere('namaBarang', 'LIKE', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('warna')) {
            $warna = $request->warna;
            $productions->whereHas('mc.colorcombine', function ($query) use ($warna) {
                $query->where('nama', 'LIKE', '%' . $warna . '%');
            });
        }

        if ($request->filled('date_start')) {
            $productions->whereDate('updated_at', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $productions->whereDate('updated_at', '<=', $request->date_end);
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
        $old_status_opi = $opi->status_opi;

        Tracking::create([
            'user'   => Auth::user()->name,
            'tipe'   => 'OPI',
            'event'  => "Cancel OPI ".$opi->NoOPI,
            'before' => 'Status: '.$old_status_opi,
            'after'  => 'Status: Cancel',
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

        $opi->status_opi = "closed";
        $opi->lastUpdatedBy = Auth::user()->name;
        $opi->timestamps = false;

        // $opi->jumlahOrder = 0;

        $opi->save();
        // $kontrakd->save();

        return redirect()->back()->with('success', 'OPI '.$opi->NoOPI.' sudah di closed!!');


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
            $old_jumlah_opi = $opi->jumlahOrder;
            $before_opi = json_encode([
                'jumlahOrder' => $opi->jumlahOrder,
                'tglKirimDt'  => $opi->tglKirimDt,
                'keterangan'  => $opi->dt ? $opi->dt->keterangan : null,
            ]);

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
                'user'   => Auth::user()->name,
                'tipe'   => 'OPI',
                'event'  => "Update OPI ".$opi->NoOPI,
                'before' => 'Qty: '.$old_jumlah_opi.' pcs',
                'after'  => 'Qty: '.$request->jumlahOrder.' pcs',
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
        ->select('kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_d.pctToleransiKurangKontrak', 'kontrak_d.pctToleransiLebihKontrak', 'kontrak_m.tipeOrder', 'kontrak_m.keterangan as ketkontrak', 'opi_m.noOPI', 'opi_m.jumlahOrder', 'opi_m.keterangan', 'mc.namaBarang', 'opi_m.nama', 'mc.revisi', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'substance.kode as subsKode', 'mc.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxKontrak as gram', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt', 'mc.outConv', 'mc.id as mcid', 'mc.lebarSheet', 'mc.panjangSheet', 'mc.fsc')
        ->first();

        // dd($opi2);

        return view('admin.opi.pdf', compact('opi2'));
    }

    /**
     * Query dasar plan kirim: hanya kolom relasi yang dipakai agar hemat memori
     * (mis. mc.gambar tidak ikut dimuat).
     */
    private function planKirimQuery()
    {
        return Opi_M::with([
            'mc:id,kodeBarang,namaBarang,gramSheetBoxKontrak2,flute,tipeBox,panjangSheet,lebarSheet,joint',
            'kontrakm:id,kode,customer_name,poCustomer,tglKontrak,alamatKirim,keterangan',
            'dt:id,keterangan,tglKirimDt,dt_perubahan,approve_ppic',
        ])->whereRaw('LOWER(TRIM(status_opi)) = ?', ['proses']);
    }

    public function plan_kirim(Request $request)
    {
        return view('admin.opi.plan_kirim');
    }

    /**
     * Pencarian OPI Proses untuk draft plan kirim (dimuat bertahap agar ringan).
     */
    public function plan_kirim_search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'page' => 'nullable|integer|min:1',
        ]);

        $perPage = 50;
        $page = (int) $request->input('page', 1);

        $query = $this->planKirimQuery();

        if ($request->filled('start')) {
            $query->where('tglKirimDt', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->where('tglKirimDt', '<=', $request->end);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($builder) use ($search) {
                $builder->where('NoOPI', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('kontrakm', function ($q) use ($search) {
                        $q->where('customer_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('poCustomer', 'LIKE', '%' . $search . '%')
                            ->orWhere('kode', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('mc', function ($q) use ($search) {
                        $q->where('kodeBarang', 'LIKE', '%' . $search . '%')
                            ->orWhere('namaBarang', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        $items = $query->orderBy('tglKirimDt', 'asc')
            ->orderBy('NoOPI', 'asc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage + 1)
            ->get();

        $hasMore = $items->count() > $perPage;
        $items = $items->take($perPage);

        return response()->json([
            'html' => view('admin.opi._plan_kirim_rows', ['data' => $items])->render(),
            'has_more' => $hasMore,
            'next_page' => $page + 1,
        ]);
    }

    public function plan_kirim_draft_list()
    {
        $drafts = PlanKirim::withCount('items')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($draft) {
                return [
                    'id' => $draft->id,
                    'nama' => $draft->nama,
                    'jumlah' => $draft->items_count,
                    'updated_at' => $draft->updated_at ? $draft->updated_at->format('d M Y H:i') : '',
                ];
            });

        return response()->json(['drafts' => $drafts]);
    }

    public function plan_kirim_draft_show($id)
    {
        $draft = PlanKirim::with('items')->findOrFail($id);
        $ids = $draft->items->pluck('opi_id')->all();

        // Hanya OPI yang masih berstatus Proses yang dimuat kembali
        $items = $this->planKirimQuery()
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(function ($item) use ($ids) {
                return array_search($item->id, $ids);
            })
            ->values();

        return response()->json([
            'id' => $draft->id,
            'nama' => $draft->nama,
            'tgl_plan' => $draft->tgl_plan ? $draft->tgl_plan->format('Y-m-d') : null,
            'catatan' => $draft->catatan,
            'skipped' => count($ids) - $items->count(),
            'html' => view('admin.opi._plan_kirim_rows', ['data' => $items])->render(),
        ]);
    }

    public function plan_kirim_draft_store(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer|exists:plan_kirim,id',
            'nama' => 'required|string|max:150',
            'tgl_plan' => 'nullable|date',
            'catatan' => 'nullable|string|max:1000',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = array_values(array_unique($request->ids));

        $draft = DB::transaction(function () use ($request, $ids) {
            $payload = [
                'nama' => $request->nama,
                'tgl_plan' => $request->tgl_plan,
                'catatan' => $request->catatan,
                'updated_by' => Auth::id(),
            ];

            if ($request->filled('id')) {
                $draft = PlanKirim::findOrFail($request->id);
                $draft->update($payload);
                $draft->items()->delete();
            } else {
                $draft = PlanKirim::create($payload + ['created_by' => Auth::id()]);
            }

            foreach ($ids as $index => $opiId) {
                PlanKirimItem::create([
                    'plan_kirim_id' => $draft->id,
                    'opi_id' => $opiId,
                    'urutan' => $index + 1,
                ]);
            }

            return $draft;
        });

        return response()->json([
            'success' => true,
            'id' => $draft->id,
            'nama' => $draft->nama,
            'jumlah' => count($ids),
        ]);
    }

    public function plan_kirim_draft_destroy($id)
    {
        PlanKirim::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function plan_kirim_export_selected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = array_values(array_unique($request->ids));

        $data = $this->planKirimQuery()
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(function ($item) use ($ids) {
                return array_search($item->id, $ids);
            })
            ->values();

        $filename = 'Plan_Kirim_OPI_Draft_' . date('d-M-Y_His') . '.xlsx';

        return Excel::download(new PlanKirimExport($data, date('d-M-Y'), null), $filename);
    }

    public function plan_kirim_export(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start' => 'required|date',
        ]);

        // Ambil data OPI sesuai filter (sama seperti plan_kirim method)
        $data = $this->planKirimQuery()
            ->where('tglKirimDt', '>=', $request->start)
            ->orderBy('tglKirimDt', 'asc')
            ->orderBy('NoOPI', 'asc')
            ->get();

        // Format tanggal untuk filename dan display
        $start_date = date('d-M-Y', strtotime($request->start));
        $filename = "Plan_Kirim_OPI_dari_{$start_date}.xlsx";

        // Export to Excel
        return Excel::download(new PlanKirimExport($data, $start_date, null), $filename);
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
