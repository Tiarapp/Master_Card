<?php

namespace App\Http\Controllers;

use App\Models\Conv_D;
use App\Models\Conv_M;
use App\Models\HasilControl;
use App\Models\HasilConv;
use App\Models\HasilCorr;
use App\Models\HasilProduksi;
use App\Models\Mesin;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConvController extends Controller
{
    public function json()
    {
        // $data = Conv_M::get();
        $data = Conv_D::convd()->where('mesin', 'LIKE', '%STICH%');

        // dd($data != null);
        // $data = HasilCorr::hasilcorr()->get();
        return DataTables::of($data)->make(true);
    }

    public function convd(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilcorr/edit/".$row->planmid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilcorr/print/".$row->planmid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function convm(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_M::get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/conv/edit/".$row->id."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/conv/print/".$row->id."' class='btn btn-outline-secondary' type='button'>Print</a>";

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
        return view('admin.plan.conv.index');
    }

    public function create()
    {
        $mesin = Mesin::all();
        $opi = Opi_M::opi2()->get();

        // dd($opi);
        return view('admin.plan.conv.create', compact('opi','mesin'));
    }

    
    public function create_non_printing()
    {
        // $corr = HasilCorr::hasilcorr()->orderBy('next_mesin', 'asc')->get();
        $opi = Opi_M::opi2()->get();

        // dd($corr);
        return view('admin.plan.conv.nonprinting_create', compact('opi'));
    }

    
    public function store(Request $request)
    {
        $mesin = explode("||", $request->tipemesin);
        $id = array_merge($request->opi_id);

        // dd($id);

        $convm = Conv_M::create([   
            'kode' => $request->kodeplan,
            'tanggal' => $request->tgl,
            'shiftM' => $request->shift
        ]);

        // $data = count($request->noOpi);
        
        $totalpcs = 0;
        $totalkg = 0;

        for ($i=1; $i <= count($id); $i++) { 
            $temp = $id[$i-1];
            $status = 'Proses';
            $lock = 1;

            $convd = Conv_D::create([
                'opi_id'=> $request->opi_id[$temp],
                'plan_conv_m_id' => $convm->id,
                'kodeplanM' => $convm->kode,
                'shift' => $convm->shiftM,
                'dt_perubahan' => $request->dt_perubahan[$temp],
                // 'nomc' => $request->mc[$temp],               
                'nama_item' => $request->item[$temp],
                'customer' => $request->customer[$temp],
                'tipe_order' => $request->tipeOrder[$temp],
                'joint' => $request->finishing[$temp],
                'wax' => $request->wax[$temp],
                'mesin_id' => $mesin[0],
                'mesin' => $mesin[1],
                'sheet_p' => $request->sheetp[$temp],
                'sheet_l' => $request->sheetl[$temp],
                'flute' => $request->flute[$temp],
                'bentuk' => $request->tipebox[$temp],
                'warna' => $request->warna[$temp],
                'qtyOrder' => $request->order[$temp],
                'out_flexo' => $request->outconv[$temp],
                'jml_plan' => $request->plan[$temp],
                'ukuran_roll' => $request->roll[$temp],
                'bungkus' => $request->bungkus[$temp],
                'urutan'=> $request->urutan[$temp],
                // 'lain_lain' => $request->kebutuhanFlute2[$temp],
                // 'rm_order' => $request->kebutuhanBawah[$temp],
                // 'tonase' => $request->kebutuhanBawah[$temp],
                'keterangan' => $request->keterangan[$temp],
                'status' => $status,
                'lock' => $lock
            ]);

            $totalpcs = $totalpcs + $request->plan;
            $totalkg = $totalkg + $request->berat_total;
        }
        return redirect('admin/plan/conv');
    }

    public function storeNonPrinting(Request $request)
    {
        $convm = Conv_M::create([   
            'kode' => $request->kodeplan,
            'tanggal' => $request->tgl,
            'shiftM' => $request->shift
        ]);

        $data = count($request->noOpi);
        
        $rmjumlah = 0;
        $berattotal = 0;

        for ($i=1; $i <= $data ; $i++) { 
            $status = 'Proses';
            $lock = 1;

            $convd = Conv_D::create([
                'opi_id'=> $request->opi_id[$i],
                'plan_conv_m_id' => $convm->id,
                'kodeplanM' => $convm->kode,
                'shift' => $convm->shiftM,
                'tgl_kirim' => $request->dt[$i],
                'nomc' => $request->mc[$i],
                'nama_item' => $request->item[$i],
                'customer' => $request->customer[$i],
                'tipe_order' => $request->tipeOrder[$i],
                'joint' => $request->finishing[$i],
                'wax' => $request->wax[$i],
                'mesin' => $request->tipemesin,
                'sheet_p' => $request->sheetp[$i],
                'sheet_l' => $request->sheetl[$i],
                'flute' => $request->flute[$i],
                'bentuk' => $request->tipebox[$i],
                'warna' => $request->warna[$i],
                'qtyOrder' => $request->order[$i],
                'out_flexo' => $request->outconv[$i],
                'jml_plan' => $request->plan[$i],
                'ukuran_roll' => $request->roll[$i],
                'bungkus' => $request->bungkus[$i],
                'urutan'=> $request->urutan[$i],
                // 'lain_lain' => $request->kebutuhanFlute2[$i],
                // 'rm_order' => $request->kebutuhanBawah[$i],
                // 'tonase' => $request->kebutuhanBawah[$i],
                'keterangan' => $request->keterangan[$i],
                'status' => $status,
                'lock' => $lock
            ]);

            // $uphasilcorr = HasilCorr::find($request->hasilcorrid[$i])->first();
            // $uphasilcorr->sisa = $request->order[$i] - $request->plan[$i];

            // $uphasilcorr->save();
        }
            
        // $upCorrm = Conv_M::find($convm->id);

        // $upCorrm->total_RM = $rmjumlah;
        // $upCorrm->total_Berat = $berattotal;

        // $upCorrm->save();

        
        
        return redirect('admin/plan/conv');
    }

    public function conv_pdf($id)
    {
        $convm = Conv_M::find($id);
        $shift1 = Conv_D::convd()->where("plan_conv_m_id", '=', $convm->id)->get();

        // dd($shift1);

        $total1 = 0;
        $kg1 = 0;

        if (count($shift1) != 0) {
            for ($i=0; $i < count($shift1) ; $i++) { 
                $total1 = $total1 + $shift1[$i]->jml_plan;
                $kg1 = $kg1 + ($shift1[$i]->jml_plan * $shift1[$i]->mc_kg );
            }
        }

        if ($shift1[0]->mesin == 'FLEXO') {
            return view('admin.plan.conv.pdf', compact(
                'convm',
                'shift1',
                'total1', 
                'kg1',  
            ));
        } else {
            return view('admin.plan.conv.nppdf', compact(
                'convm',
                'shift1',
                'total1', 
                'kg1',  
            ));
        }
    }

    public function edit($id)
    {
        
        // $hasilcorr = HasilCorr::hasilcorr()->get();
        
        $opi = Opi_M::opi2()->get();
        $data1 = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->get();
        $mesin = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->first();
        $data2 = Conv_M::where('plan_conv_m.id', '=', $id)->first();

        // dd($data2);


        // dd($mesin);
        return view('admin.plan.conv.edit', compact('data1','data2','opi','mesin'));
    }

    public function update(Request $request, $id)
    {
        $data1 = $request->noOpi;
        // $mesin = $request->mesin;
        // dd($data1);

        for ($i=1; $i <= count($data1); $i++) { 
            // dd($request->detail[$i]);
            if ($request->detail[$i] != NULL) {
                $corrd = Conv_D::find($request->detail[$i]);

                $corrd->urutan = $request->urutan[$i];
                $corrd->jml_plan = $request->plan[$i];
                $corrd->keterangan = $request->keterangan[$i];

                $corrd->save();
            } else {
                // dd($request->detail[$i]);
                if ($request->detail[$i] == NULL) {
                    if ($request->noOpi[$i] != '') {
                        // dd($request->kodeplan);
                        $add_detail = Conv_D::create([
                            'plan_conv_m_id' => $id,
                            'kodeplanM' => $request->kodeplan,
                            'opi_id' => $request->opi_id[$i],
                            'tgl_kirim' => $request->dt[$i],
                            'nomc' => $request->mc[$i],
                            'urutan' => $request->urutan[$i],
                            'sheet_p' => $request->sheetp[$i],
                            'sheet_l' => $request->sheetl[$i],
                            'customer' => $request->customer[$i],
                            'nama_item' => $request->item[$i],
                            'flute' => $request->flute[$i],
                            'bentuk' => $request->tipebox[$i],
                            'mesin' => $request->mesin,
                            'out_flexo' => $request->outconv[$i],
                            'qtyOrder' => $request->order[$i],
                            'jml_plan' => $request->plan[$i],
                            'warna' => $request->warna[$i],
                            'joint' => $request->finishing[$i],
                            'tipe_order' => $request->tipeOrder[$i],
                            'keterangan' => $request->keterangan[$i],
                        ]);
                    }

                    // dd($add_detail);
                }
            }
            
            // $rmjumlah = $rmjumlah + $request->rmorder[$i];
            // $berattotal = $berattotal + $request->beratOrder[$i];
            
        }

        return redirect('admin/plan/conv');
    }

    

    // public function convd_tokai(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Conv_D::convd()->where('plan_conv_d.mesin', '=', 'TOKAI')->get();
    //         // dd($data);              
    //         return DataTables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
     
    //                     $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
    //                     <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

    //                     return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //         // dd($data);                    
    //     }
    //     // return view('admin.plan.corr.index');
    // }

    // public function convd_stich(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Conv_D::convd()->where('plan_conv_d.mesin', 'LIKE', '%STICH%')->get();
    //         return DataTables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
     
    //                     $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
    //                     <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

    //                     return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //         // dd($data);                    
    //     }
    //     // return view('admin.plan.corr.index');
    // }

    // public function convd_wax(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Conv_D::convd()->where('plan_conv_d.mesin', '=', 'WAX')->get();
    //         return DataTables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
     
    //                     $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
    //                     <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

    //                     return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //         // dd($data);                    
    //     }
    //     // return view('admin.plan.corr.index');
    // }
    
    // public function convd_slitter(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Conv_D::convd()->where('plan_conv_d.mesin', '=', 'SLITTER')->get();
    //         return DataTables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
     
    //                     $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
    //                     <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

    //                     return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //         // dd($data);                    
    //     }
    //     // return view('admin.plan.corr.index');
    // }

    // public function convd_glue(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Conv_D::convd()->where('plan_conv_d.mesin', '=', 'GLUE MANUAL')->get();
    //         return DataTables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
     
    //                     $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
    //                     <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

    //                     return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //         // dd($data);                    
    //     }
    //     // return view('admin.plan.corr.index');
    // }


    // public function index_hasil_tokai()
    // {
    //     return view('admin.plan.hasilconv.indextokai');
    // }

    // public function index_hasil_stich()
    // {
    //     return view('admin.plan.hasilconv.indexstich');
    // }

    // public function index_hasil_wax()
    // {
    //     return view('admin.plan.hasilconv.indexwax');
    // }

    // public function index_hasil_slitter()
    // {
    //     return view('admin.plan.hasilconv.indexslitter');
    // }

    // public function index_hasil_glue()
    // {
    //     return view('admin.plan.hasilconv.indexglue');
    // }

    public function edit_hasil_conv($id)
    {
        
        // $hasilcorr = HasilConv::hasilcorr()->get();
        $data1 = Conv_D::convd()->where('plan_conv_d.id', '=', $id)->first();

        $data2 = Conv_M::where('plan_conv_m.id', '=', $id)->first();

        // dd($data1,$data2);
        return view('admin.plan.hasilconv.edit', compact('data1','data2',));
    }

    // public function storeEdit(Request $request)
    // {

    //     $control = HasilControl::where('noOpi', '=', $request->noopi )->first();
    //     $flexo = HasilControl::where('noOpi', '=', $request->noopi )->where('tgl_flexo', '=', $request->tglhasil)->first();
    //     $tokai = HasilControl::where('noOpi', '=', $request->noopi )->where('tgl_tokai', '=', $request->tglhasil)->first();
    //     $stitch = HasilControl::where('noOpi', '=', $request->noopi )->where('tgl_stitch', '=', $request->tglhasil)->first();
    //     $wax = HasilControl::where('noOpi', '=', $request->noopi )->where('tgl_wax', '=', $request->tglhasil)->first();
    //     $slitter = HasilControl::where('noOpi', '=', $request->noopi )->where('tgl_slitter', '=', $request->tglhasil)->first();
    //     $glue = HasilControl::where('noOpi', '=', $request->noopi )->where('tgl_glue', '=', $request->tglhasil)->first();

    //     dd($flexo);

    //     if($request->mesin == 'FLEXO')
    //     {
    //         if($flexo != null)
    //         { 
    //             $uphasilconv = HasilConv::where('noOpi', '=', $request->noopi)
    //             ->where('tgl_mesin1', '=', $request->tglhasil)->first();
    //             if ($uphasilconv != null) {
    //                 // $uphasilconv->tgl_mesin1 = $request->tglhasil; 
    //                 $uphasilconv->mesin1 = $request->mesin;
    //                 $uphasilconv->hasil_baik_mesin1 = $request->hasil_baik;
    //                 $uphasilconv->hasil_jelek_mesin1 = $request->hasil_jelek;

    //                 $uphasilconv->save();

    //                 $flexo->tgl_flexo = $request->tglhasil; 
    //                 $flexo->flexo = $request->mesin;
    //                 $flexo->hasil_baik_flexo = $request->hasil_baik;
    //                 $flexo->hasil_jelek_flexo = $request->hasil_jelek;

    //                 $flexo->save();

    //             } else {

    //             }
    //         }
    //     }
        
    // }

    public function control() 
    {
        $control = Opi_M::opi()->get();

        dd($control);

        return view('admin.plan.hasilconv.control', compact('control'));
    }
}
