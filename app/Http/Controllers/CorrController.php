<?php

namespace App\Http\Controllers;

use App\Models\Corr_D;
use App\Models\Corr_M;
use App\Models\HasilControl;
use App\Models\HasilCorr;
use App\Models\Opi_M;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Yajra\DataTables\DataTables;

class CorrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function json()
    {
        $data = Opi_M::opi2()->get();
        return Datatables::of($data)->make(true);
    }

    public function corrd(Request $request)
    {
        if ($request->ajax()) {
            $data = Corr_D::corr()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilcorr/edit/".$row->corrdid."' class='edit btn btn-primary btn-sm'>Edit Hasil</a>
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
            'tanggal' => $request->tgl
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
                        'sheet_p' => $request->sheetp[$i],
                        'sheet_l' => $request->sheetl[$i],
                        'flute' => $request->flute[$i],
                        'bentuk' => $request->tipebox[$i],
                        'out_corr' => $request->outCorr[$i],
                        'out_flexo' => $request->outFlexo[$i],
                        'qtyOrder' => $request->plan[$i],
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
    public function index_hasil_corr()
    {
        return view('admin.plan.hasilcorr.index');
    }

    public function edit_hasil_corr($id)
    {
        $corrd = Corr_D::corr()->where('plan_corr_d.id','=',$id)->first();
        // dd($corrd);
        return view('admin.plan.hasilcorr.edit', compact('corrd'));
    }

    public function update_hasil_corr(Request $request)
    {
       $upcorr = Corr_D::find($request->plandid);
       $upcorr->sisa = $request->sisa;
       if ($upcorr->sisa <= 0) {
           $upcorr->status = 'Selesai';
       }
       else {
           $upcorr->status = 'Belum Selesai';
       }

       $upcorr->save();
       
        $startdate = date('Y-m-d H:i:s', strtotime($request->start));
        $enddate = date('Y-m-d H:i:s', strtotime($request->end));
        
        $hasilcorr = HasilCorr::create([
        'plan_corr_m_id' => $request->planmid,
        'plan_corr_d_id' => $request->plandid,
        'opi_id' => $request->opi_id,
        'no_opi' => $request->noopi,
        'hasil_baik' => $request->baik,
        'hasil_jelek' => $request->jelek,
        'sisa' => $request->baik,
        'start_prod' => $startdate,
        'end_prod' => $enddate,
        'prod_time' => $request->durasi,
        'prod_meter' => $request->prod_meter,
        'm2' => $request->meter_persegi,
        'jml_palet' => $request->jml_palet,
        'status' => $request->status,
        'next_mesin' => $request->mesin,
       ]);

       $control = HasilControl::where('noOpi', '=', $request->noopi )->first();

       if($control != null){
            $mesin = "CORR";
            $uphasilcontrol = HasilControl::where('noOpi', '=', $request->noopi )->first();

            $uphasilcontrol->tgl_corr = date('Y-m-d', strtotime($request->end));
            $uphasilcontrol->corr = $mesin;
            $uphasilcontrol->hasil_baik_corr = $request->baik;
            $uphasilcontrol->hasil_jelek_corr = $request->jelek;

            $uphasilcontrol->save();
       } else {
           $mesin = "CORR";
           HasilControl::create([
            'corr' => $mesin,
            'tgl_corr' => $request->tglhasil,
            'opi_id' => $request->opi_id,
            'noOpi' => $request->noopi,
            'jml_Order' => $request->plan,
            'hasil_baik_corr' => $request->hasil_baik,
            'hasil_jelek_corr' => $request->hasil_jelek
           ]);
       }

    //    dd($hasilcorr);

         return redirect('admin/plan/hasilcorr');
    }
}
