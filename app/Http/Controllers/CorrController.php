<?php

namespace App\Http\Controllers;

use App\Models\Corr_D;
use App\Models\Corr_M;
use App\Models\HasilProduksi;
use App\Models\Mesin;
use App\Models\Opi_M;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CorrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // public function json()
    // {
    //     $data = Opi_M::opi2()->get();
    //     return Datatables::of($data)->make(true);
    // }

    public function corrd(Request $request)
    {
        if ($request->ajax()) {
            $data = Corr_D::corr()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilcorr/edit/".$row->opi_id."' class='edit btn btn-primary btn-sm'>Edit Hasil</a>
                        ";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function corrm(Request $request)
    {
        if ($request->ajax()) {
            $data = Corr_M::get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/corr/edit/".$row->id."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/corr/print/".$row->id."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);
        }
        // return view('admin.plan.corr.index');
    }

    public function index()
    {
        return view('admin.plan.corr.index');
    }
    
    public function input_hasil()
    {
        $data = Corr_M::get();
        return view('admin.plan.hasilcorr.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opi = Opi_M::opi2()->get();
        
        // dd($opi);
        return view('admin.plan.corr.create', compact('opi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $corrm = Corr_M::create([   
            'kode_plan' => $request->kodeplan,
            'tanggal' => $request->tgl,
            'shift' => $request->shift
        ]);

        $data = count($request->noOpi);
        
        $rmjumlah = 0;
        $berattotal = 0;

        for ($i=1; $i <= $data ; $i++) { 
            // $kodeplan = $request->kodeplan;
            // $urutan = $request->urutan;
            $status = 'Proses';
            $lock = 1;

            // dd($kodeplan,$urutan);
            $corrd = Corr_D::create([
                'opi_id'=> $request->opi_id[$i],
                'plan_corr_m_id' => $corrm->id,
                'kode_plan_d' => $request->kodeplan,
                'urutan' => $request->urutan[$i],
                'dt_perubahan' => $request->dtperubahan[$i],
                'sheet_p' => $request->sheetp[$i],
                'sheet_l' => $request->sheetl[$i],
                'flute' => $request->flute[$i],
                'bentuk' => $request->tipebox[$i],
                'out_corr' => $request->outCorr[$i],
                'out_flexo' => $request->outFlexo[$i],
                'qtyOrder' => $request->plan[$i],
                'jml_order' => $request->order[$i],
                'sisa' => $request->plan[$i],
                'ukuran_roll' => $request->roll[$i],
                'custom_roll' => $request->rollcustom[$i],
                'cop' => $request->cop[$i],
                'trim_waste' => $request->trim[$i],
                'rm_order' => $request->rmorder[$i],
                'tonase' => $request->beratOrder[$i],
                'jenis_atas' => $request->kertasAtas[$i],
                'gram_atas' => $request->gramAtas[$i],
                'jenis_bf' => $request->kertasFlute1[$i],
                'gram_bf' => $request->gramFlute1[$i],
                'jenis_tengah' => $request->kertasTengah[$i],
                'gram_tengah' => $request->gramTengah[$i],
                'jenis_cf' => $request->kertasFlute2[$i],
                'gram_cf' => $request->gramFlute2[$i],
                'jenis_bawah' => $request->kertasBawah[$i],
                'gram_bawah' => $request->gramBawah[$i],
                'kebutuhan_kertasAtas' => $request->kebutuhanAtas[$i],
                'kebutuhan_kertasFlute1' => $request->kebutuhanFlute1[$i],
                'kebutuhan_kertasTengah' => $request->kebutuhanTengah[$i],
                'kebutuhan_kertasFlute2' => $request->kebutuhanFlute2[$i],
                'kebutuhan_kertasBawah' => $request->kebutuhanBawah[$i],
                'keterangan' => $request->keterangan[$i],
                'toleransi' => $request->toleransi[$i],
                'status' => $status,
                'lock' => $lock
            ]);

            $rmjumlah = $rmjumlah + $request->rmorder[$i];
            $berattotal = $berattotal + $request->beratOrder[$i];
        }
            
        $upCorrm = Corr_M::find($corrm->id);

        $upCorrm->total_RM = $rmjumlah;
        $upCorrm->total_Berat = $berattotal;

        $upCorrm->save();
        
        return redirect('admin/plan/corr');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $corr = Corr_D::find($id);
        
        $corr->delete();

        return redirect()->to(url()->previous());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $opi = Opi_M::opi2()->get();
        $data1 = Corr_D::corrprint()->where('plan_corr_m.id', '=', $id)->orderBy('urutan','asc')->get();

        $data2 = Corr_D::corrprint()->where('plan_corr_m.id', '=', $id)->first();

        // dd($data2);
        return view('admin.plan.corr.edit', compact('data1','data2','opi'));
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
        $data1 = $request->noOpi;
        
        // dd($data1);
        $rmjumlah = 0;
        $berattotal = 0;

        for ($i=1; $i <= count($data1); $i++) { 
            // dd($request->detail[$i]);
            if ($request->detail[$i] != '') {
                $corrd = Corr_D::find($request->detail[$i]);
                // dd($corrd);
                $corrd->plan_corr_m_id = $id;
                $corrd->opi_id = $request->opi_id[$i];
                $corrd->urutan = $request->urutan[$i];
                $corrd->dt_perubahan = $request->dtperubahan[$i];
                $corrd->sheet_p = $request->sheetp[$i];
                $corrd->sheet_l = $request->sheetl[$i];
                $corrd->bentuk = $request->tipebox[$i];
                $corrd->flute = $request->flute[$i];
                $corrd->out_corr = $request->outCorr[$i];
                $corrd->out_flexo = $request->outFlexo[$i];
                $corrd->qtyOrder = $request->plan[$i];
                $corrd->jml_order = $request->order[$i];
                $corrd->sisa = $request->plan[$i];
                $corrd->ukuran_roll = $request->roll[$i];
                $corrd->custom_roll = $request->rollcustom[$i];
                $corrd->cop = $request->cop[$i];
                $corrd->trim_waste = $request->trim[$i];
                $corrd->jenis_atas = $request->kertasAtas[$i];
                $corrd->gram_atas = $request->gramAtas[$i];
                $corrd->jenis_bf = $request->kertasFlute1[$i];
                $corrd->gram_bf = $request->gramFlute1[$i];
                $corrd->jenis_tengah = $request->kertasTengah[$i];
                $corrd->gram_tengah = $request->gramTengah[$i];
                $corrd->jenis_cf = $request->kertasFlute2[$i];
                $corrd->gram_cf = $request->gramFlute2[$i];
                $corrd->jenis_bawah = $request->kertasBawah[$i];
                $corrd->gram_bawah = $request->gramBawah[$i];
                $corrd->kebutuhan_kertasAtas = $request->kebutuhanAtas[$i];
                $corrd->kebutuhan_kertasFlute1 = $request->kebutuhanFlute1[$i];
                $corrd->kebutuhan_kertasTengah = $request->kebutuhanTengah[$i];
                $corrd->kebutuhan_kertasFlute2 = $request->kebutuhanFlute2[$i];
                $corrd->kebutuhan_kertasBawah = $request->kebutuhanBawah[$i];
                $corrd->tonase = $request->beratOrder[$i];
                $corrd->toleransi = $request->toleransi[$i];
                $corrd->rm_order = $request->rmorder[$i];
                $corrd->keterangan = $request->keterangan[$i];

                $corrd->save();
            } else {
                if ($request->detail[$i] == '') {
                    Corr_D::create([
                        'plan_corr_m_id' => $id,
                        'opi_id' => $request->opi_id[$i],
                        'kode_plan_d' => $request->kodeplan,
                        'urutan' => $request->urutan[$i],
                        'dt_perubahan' => $request->dtperubahan[$i],
                        'sheet_p' => $request->sheetp[$i],
                        'sheet_l' => $request->sheetl[$i],
                        'flute' => $request->flute[$i],
                        'bentuk' => $request->tipebox[$i],
                        'out_corr' => $request->outCorr[$i],
                        'out_flexo' => $request->outFlexo[$i],
                        'qtyOrder' => $request->plan[$i],
                        'jml_order' => $request->order[$i],
                        'sisa' => $request->plan[$i],
                        'ukuran_roll' => $request->roll[$i],
                        'custom_roll' => $request->rollcustom[$i],
                        'cop' => $request->cop[$i],
                        'trim_waste' => $request->trim[$i],
                        'rm_order' => $request->rmorder[$i],
                        'tonase' => $request->beratOrder[$i],
                        'jenis_atas' => $request->kertasAtas[$i],
                        'gram_atas' => $request->gramAtas[$i],
                        'jenis_bf' => $request->kertasFlute1[$i],
                        'gram_bf' => $request->gramFlute1[$i],
                        'jenis_tengah' => $request->kertasTengah[$i],
                        'gram_tengah' => $request->gramTengah[$i],
                        'jenis_cf' => $request->kertasFlute2[$i],
                        'gram_cf' => $request->gramFlute2[$i],
                        'jenis_bawah' => $request->kertasBawah[$i],
                        'gram_bawah' => $request->gramBawah[$i],
                        'kebutuhan_kertasAtas' => $request->kebutuhanAtas[$i],
                        'kebutuhan_kertasFlute1' => $request->kebutuhanFlute1[$i],
                        'kebutuhan_kertasTengah' => $request->kebutuhanTengah[$i],
                        'kebutuhan_kertasFlute2' => $request->kebutuhanFlute2[$i],
                        'kebutuhan_kertasBawah' => $request->kebutuhanBawah[$i],
                        'keterangan' => $request->keterangan[$i],
                        'status' => "Proses",
                        'lock' => 1
                    ]);
                }
            }
            
            $rmjumlah = $rmjumlah + $request->rmorder[$i];
            $berattotal = $berattotal + $request->beratOrder[$i];
        }

        $upCorrm = Corr_M::find($id);

        $upCorrm->total_RM = $rmjumlah;
        $upCorrm->revisi = $request->revisi;
        $upCorrm->total_Berat = $berattotal;
        $upCorrm->shift = $request->shift;

        $upCorrm->save();
        
        return redirect('admin/plan/corr');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function corr_pdf($id)
    {
        $data1 = Corr_D::corrprint()->where('plan_corr_m.id', '=', $id)->orderBy('urutan','asc')->get();

        // $data1= $data->sortBy('urutan','asc');
        $data2 = Corr_D::corrprint()->where('plan_corr_m.id', '=', $id)->first();

        // dd($data2);
        return view('admin.plan.corr.pdfcorr', compact('data1','data2'));
    }

    // Hasil Corr

    
    public function control()
    {
        return view('admin.plan.control.index');
    }

    
    public function json(Request $request)
    {
        $columns = array(
            0=>'id', 1=>'NoOPI',2=>'action',3=>'kode', 4=>'created_at',5=>'tglKirimDt',6=>'pcsDt',7=>'Cust', 8=>'namaBarang',9=>'jumlahOrder',10=>'sisa_order', 11=>'keterangan', 12=>'NoOPI',
            13=>'poCustomer', 14=>'mcKode',15=>'hariKirimDt',16=>'flute',17=>'tipeBox',18=>'panjangSheet',19=>'lebarSheet',20=>'outConv',21=>'Ukroll',22=>'tipeOrder',23=>'namacc',24=>'joint',25=>'KertasAtas',26=>'KAtas',27=>'Kbf',28=>'KTengah',29=>'Kcf',30=>'KBawah',31=>'KertasBawah',32=>'wax',33=>'gram',34=>'tglKontrak',35=>'alamatKirim',36=>'toleransi',37=>'panjang',38=>'lebar',39=>'tinggi',40=>'koli',41=>'tglKirimDt',42=>'harga_kg',43=>'realisasiKirim',44=>'sisaDt',45=>'status',46=>'noKontrak',47=>'tglKontrak',48=>'KertasKAtas', 49=>'KAtasP', 50=>'KbfP', 51=>'KTengahP', 52=>'KcfP',53=>'KBawahP', 54=>'KertasBawahP', 55=>'null',54=>'kodeBarang',56=>'tipeCreasCorr',57=>'bungkus',58=>'lain'
        );

        $totalData = Opi_M::control()->count();
        $limit = $request->input('length');
        $start = $request->input('start');

        // dd($start, $limit);
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $opi = Opi_M::control()->offset($start)
                         ->limit(100)
                         ->orderBy('NoOPI')
                        //  ->where('NoOPI', 'NOT LIKE', "%CANCEL%")
                         ->get();
                         
            $totalFiltered = Opi_M::control()->count();
            // dd($opi);
        }
        else {
            $search = $request->input('search.value'); 

            $opi =  Opi_M::control()->where('kontrak_m.customer_name','LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.poCustomer', 'LIKE',"%{$search}%")
                            ->orWhere('kontrak_m.kode', 'LIKE',"%{$search}%")
                            ->orWhere('NoOPI', 'LIKE',"%{$search}%")
                            ->orWhere('mc.namaBarang', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit(100)
                            ->orderBy($order, $dir)
                            ->get();

            $totalFiltered = Opi_M::control()->where('kontrak_m.customer_name','LIKE',"%{$search}%")
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
                $show =  route('detail',$opi->id);
                // $edit =  route('hasilcorr.edit',$opi->id);
                // $cancel = route('opi.cancel', $opi->id);

                $cek_opi = strpos($opi->nama,"CANCEL");

                $nestedData['id'] = $opi->id;
                $nestedData['NoOPI'] = $opi->NoOPI;

                $nestedData['action'] = "<a href='{$show}' title='SHOW' class='btn btn-outline-success' type='button'><i class='far fa-eye' data-toggle='tooltip' data-placement='bottom' title='Detail' id='Detail'></i></a>";
                $nestedData['kode'] = $opi->kode;
                $nestedData['created_at'] = date('j M Y',strtotime($opi->created_at));
                $nestedData['tglKirimDt'] = $opi->tglKirimDt;
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

    public function show($id)
    {
        $opi = Opi_M::opi()->where('opi_m.id', '=', $id)->first();
        
        $detail = HasilProduksi::where('opi_id', '=', $id)->orderBy('start_date','asc')->get();

        // dd($detail);

        return view('admin.plan.hasilcorr.show', compact('opi','detail'));
    }
}
