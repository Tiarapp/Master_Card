<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use App\Models\Opi_M;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $opi = Opi_M::opi()->offset($start)
                         ->limit(100)
                         ->orderBy('NoOPI')
                         ->get();
                         
            $totalFiltered = Opi_M::opi()->count();
            // dd($opi);
        }
        else {
            $search = $request->input('search.value'); 

            $opi =  Opi_M::opi()->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.poCustomer', 'LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.kode', 'LIKE',"%{$search}%")
                            ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                            ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit(100)
                            ->orderBy($order, $dir)
                            ->get();

            $totalFiltered = Opi_M::opi()->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                             ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                             ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                             ->count();
            // dd($opi);
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

                $cek_opi = strpos($opi->nama,"CANCEL");

                $nestedData['id'] = $opi->id;
                $nestedData['NoOPI'] = $opi->NoOPI;

                if ($cek_opi == '') {    
                    $nestedData['action'] = "<a href='{$show}' title='SHOW' class='btn btn-outline-success' type='button'><i class='far fa-eye' data-toggle='tooltip' data-placement='bottom' title='Print' id='Print'></i></a>
                    <a href='{$cancel}' class='btn btn-outline-danger' type='button' title='CANCEL' ><i class='far fa-window-close' data-toggle='tooltip' data-placement='bottom' title='CANCEL' id='CANCEL'></i></a>";
                } else {
                
                    $nestedData['action'] = "<a href='{$show}' title='SHOW' class='btn btn-outline-success' type='button'><i class='fa fa-eye' data-toggle='tooltip' data-placement='bottom' title='Print' id='Print'></i></a>
                    ";
                }
                $nestedData['kode'] = $opi->kode;
                $nestedData['created_at'] = date('j M Y',strtotime($opi->created_at));

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
                $nestedData['keterangan'] = $opi->keterangan;
                $nestedData['NoOPI'] = $opi->NoOPI;
                $nestedData['poCustomer'] = $opi->poCustomer;

                if ($opi->revisimc == '') {
                    $mc = $opi->mcKode;
                } else if ($opi->revisimc == "R0") {
                    $mc = $opi->mcKode;
                } else {
                    $mc = $opi->mcKode.'-'.$opi->revisimc;
                }
                // $mc = ($opi->revisimc != '' ? $opi->mcKode.'-'.$opi->revisimc : $opi->mcKode );

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
                $nestedData['gram'] = $opi->gram;
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
                // $nestedData['kertasMcAtasK'] = $opi->kertasMcAtasK;
                $nestedData['gramKertasAtasK'] = $opi->gramKertasAtasK;
                $nestedData['gramKertasflute1K'] = $opi->gramKertasflute1K;
                $nestedData['gramKertastengahK'] = $opi->gramKertastengahK;
                $nestedData['gramKertasflute2K'] = $opi->gramKertasflute2K;
                $nestedData['gramKertasbawahK'] = $opi->gramKertasbawahK;
                $nestedData['kertasMcbawahK'] = ($opi->kertasMcbawahK == "BK" ? "K" : $opi->kertasMcbawahK);
                // $nestedData['kertasMcbawahK'] = $opi->kertasMcbawahK;
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
    
    public function index(Request $request)
    {
        $data = Opi_M::opi()->limit(100)->get();
        return view('admin.opi.index', compact('data'));
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
        $day = date("D", $request->tglKirimDt);
        
        $lastOpi = Opi_M::latest()->first();
        $alphabet = "B";
        $nomer = preg_replace('/[^0-9]/', '', $lastOpi->nama)+1;
        $numb_opi = $nomer.$alphabet;
        
        $checkMesin = Opi_M::opi()->where('dt.tglKirimDt', '=', $request->tglKirim)->get();

        // dd($checkMesin);
        $totalB1 = 0;
        $totaldc = 0;
        $lain = 0;

        foreach ($checkMesin as $mesin) {
            if ($mesin->tipeBox == 'B1') {
                $totalB1 = $totalB1 + $mesin->jumlahOrder;
            } else if ($mesin->tipeBox == 'DC') {
                $totaldc = $totaldc + $mesin->jumlahOrder;
            } else {
                $lain = $mesin->jumlahOrder + $lain;
            }
        }

        // dd($totalB1, $totaldc + $request->jumlahOrder);

    
        $checkOpi = Opi_M::where('nama', '=', $numb_opi )->first();
        // dd($numb_opi);

        if ($checkOpi == null) {
        
            $kontrakd = Kontrak_D::where('id', '=', $request->kontrakdid)->first();
            
            if ($request->jumlahOrder > $kontrakd->pcsSisaKontrak ) {
                return redirect('admin/opi/create')->with('error', 'Sisa kontrak tidak mencukupi, maksimal '.$kontrakd->pcsSisaKontrak);
            } else 
            if ($request->bentuk == 'B1') {    
                if ($request->jumlahOrder + $totalB1 > 15000) {
                    return redirect('admin/opi/create')->with('error', 'Kapasitas OPI B1 pada tanggal tersebut sudah maksimal');
                } 
            } else 
            if ($request->bentuk == 'DC') {
                if ($request->jumlahOrder + $totaldc > 54000) {
                    return redirect('admin/opi/create')->with('error', 'Kapasitas OPI DC pada tanggal tersebut sudah maksimal');
                } 
            }
            {

                $opim = Opi_M::create([   
                    'nama' => $numb_opi,
                    'NoOPI' => $numb_opi,
                    'dt_id' => $request->dtid,
                    'mc_id' => $request->mcid,
                    'kontrak_m_id' => $request->kontrakmid,
                    'kontrak_d_id' => $request->kontrakdid,
                    'keterangan' => $request->keterangan,
                    'tglKirimDt' => $request->tglKirim,
                    'jumlahOrder' => $request->jumlahOrder,
                    'sisa_order' => $request->jumlahOrder,
                    'hariKirimDt' => $day,
                    'createdBy' => Auth::user()->name,
                ]);

                $kontrakd->pcsSisaKontrak = $kontrakd->pcsSisaKontrak - $request->jumlahOrder;
                $kontrakd->kgSisaKontrak = ($kontrakd->kgSisaKontrak*$request->berat) - ($request->jumlahOrder*$request->berat);
            }

            $kontrakd->save();
        
            // dd($kontrakd);

                return redirect('admin/opi')->with('success', 'OPI Berhasi disimpan dengan Nomor OPI '.$numb_opi );
        } else {
                return redirect('admin/opi/create')->with('error', 'No OPI Sudah Ada, Silahkan isi OPI Ulang');
        }
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

        $opi->nama = $opi->nama."(CANCEL)";
        $opi->NoOPI = $opi->NoOPI."(CANCEL)";


        $opi->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function edit(Opi_M $opi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opi_M $opi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $opi = DB::table('opi_m')
            ->leftJoin('dt', 'dt_id', 'dt.id')
            ->leftJoin('mc', 'mc_id', 'mc.id')
            ->leftJoin('box', 'mc.box_id', 'box.id')
            ->leftJoin('substance', 'mc.substanceProduksi_id', 'substance.id')
            ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
            ->where('opi_m.id', '=', $id)
            ->select('opi_m.noOPI', 'opi_m.jumlahOrder', 'opi_m.keterangan', 'mc.namaBarang', 'opi_m.nama', 'mc.revisi', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'substance.kode as subsKode', 'mc.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi as gram', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt', 'mc.outConv', 'mc.id as mcid' )
            ->first();

        $opi2 = DB::table('opi_m')
        ->leftJoin('kontrak_m', 'kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('kontrak_d', 'kontrak_d_id', 'kontrak_d.id')
        ->where('opi_m.id', '=', $id)
        ->select('kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_d.pctToleransiKurangKontrak', 'kontrak_d.pctToleransiLebihKontrak', 'kontrak_m.tipeOrder' )
        ->first();

        // dd($opi);

        return view('admin.opi.pdf', compact('opi','opi2'));
    }
}
