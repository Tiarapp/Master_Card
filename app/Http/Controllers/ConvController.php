<?php

namespace App\Http\Controllers;

use App\Models\Conv_D;
use App\Models\Conv_M;
use App\Models\HasilConv;
use App\Models\HasilCorr;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConvController extends Controller
{
    public function json()
    {
        // $data = Conv_M::get();
        $data = Conv_D::convd()->get();
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
    public function index_printing_conv()
    {
        return view('admin.plan.conv.index');
    }

    public function create_printing()
    {
        // $corr = HasilCorr::hasilcorr()->orderBy('next_mesin', 'asc')->get();
        $opi = Opi_M::opi2()->get();

        // dd($corr);
        return view('admin.plan.conv.printing_create', compact('opi'));
    }

    
    public function create_non_printing()
    {
        // $corr = HasilCorr::hasilcorr()->orderBy('next_mesin', 'asc')->get();
        $opi = Opi_M::opi2()->get();

        // dd($corr);
        return view('admin.plan.conv.nonprinting_create', compact('opi'));
    }

    
    public function storeFlexoA(Request $request)
    {
        $convm = Conv_M::create([   
            'kode' => $request->kodeplan,
            'tanggal' => $request->tgl,
            'shift' => $request->shift
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
                'tgl_kirim' => $request->dt[$i],
                'nomc' => $request->mc[$i],
                'nama_item' => $request->item[$i],
                'customer' => $request->customer[$i],
                'tipe_order' => $request->tipeOrder[$i],
                'joint' => $request->finishing[$i],
                'wax' => $request->wax[$i],
                'mesin' => $request->mesin,
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

    public function storeNonPrinting(Request $request)
    {
        $convm = Conv_M::create([   
            'kode' => $request->kodeplan,
            'tanggal' => $request->tgl,
            'shift' => $request->shift
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
                'tgl_kirim' => $request->dt[$i],
                'nomc' => $request->mc[$i],
                'nama_item' => $request->item[$i],
                'customer' => $request->customer[$i],
                'tipe_order' => $request->tipeOrder[$i],
                'joint' => $request->finishing[$i],
                'wax' => $request->wax[$i],
                'mesin' => $request->mesin,
                'qtyOrder' => $request->order[$i],
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
        $convm = Conv_M::find($id)->first();
        $convd = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->orderBy('urutan','asc')->get();
        // dd($convm); 
        if ($convd[0]->mesin == 'FLEXO') {
            return view('admin.plan.conv.pdf', compact('convm','convd'));
        } else {
            return view('admin.plan.conv.nppdf', compact('convm','convd'));
        }
    }

    public function edit($id)
    {
        
        // $hasilcorr = HasilCorr::hasilcorr()->get();
        
        $opi = Opi_M::opi2()->get();
        $data1 = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->get();
        $mesin = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->first();
        $data2 = Conv_M::where('plan_conv_m.id', '=', $id)->first();

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
                    $add_detail = Conv_D::create([
                        'plan_conv_m_id' => $id,
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

                    // dd($add_detail);
                }
            }
            
            // $rmjumlah = $rmjumlah + $request->rmorder[$i];
            // $berattotal = $berattotal + $request->beratOrder[$i];
            
        }

        return redirect('admin/plan/conv');
    }

    public function convd_flexo(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->where('mesin', '=', 'FLEXO')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function convd_tokai(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->where('mesin', '=', 'TOKAI')->get();
            // dd($data);              
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function convd_stich(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->where('mesin', '=', 'STICHING')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function convd_wax(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->where('mesin', '=', 'WAX')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }
    
    public function convd_slitter(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->where('mesin', '=', 'SLITTER')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function convd_glue(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::convd()->where('mesin', '=', 'GLUE MANUAL')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../plan/hasilconvflexo/edit/".$row->plandid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilconvflexo/print/".$row->plandid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    public function index_hasil_flexo()
    {
        return view('admin.plan.hasilconv.indexflexo');
    }

    public function index_hasil_tokai()
    {
        return view('admin.plan.hasilconv.indextokai');
    }

    public function index_hasil_stich()
    {
        return view('admin.plan.hasilconv.indexstich');
    }

    public function index_hasil_wax()
    {
        return view('admin.plan.hasilconv.indexwax');
    }

    public function index_hasil_slitter()
    {
        return view('admin.plan.hasilconv.indexslitter');
    }

    public function index_hasil_glue()
    {
        return view('admin.plan.hasilconv.indexglue');
    }

    public function edit_hasil_conv($id)
    {
        
        // $hasilcorr = HasilConv::hasilcorr()->get();
        $data1 = Conv_D::convd()->where('plan_conv_d.id', '=', $id)->first();

        $data2 = Conv_M::where('plan_conv_m.id', '=', $id)->first();

        // dd($data1,$data2);
        return view('admin.plan.hasilconv.edit', compact('data1','data2',));
    }

    public function storeEdit(Request $request)
    {
        $hasilconv = HasilConv::where('noOpi', '=', $request->noopi )->first();

        // dd($hasilconv);

        if ($hasilconv != null) {
            // $uphasilconv = HasilConv::find($request->noopi)->first();
        $uphasilconv = HasilConv::where('noOpi', '=', $request->noopi )->first();
            if ($request->mesin == 'FLEXO') {
                $uphasilconv->mesin1 = $request->mesin;
                $uphasilconv->hasil_baik_mesin1 = $request->hasil_baik;
                $uphasilconv->hasil_jelek_mesin1 = $request->hasil_jelek;

                $uphasilconv->save();

                return redirect('admin/plan/hasilconvflexo');
            }
            if ($request->mesin == 'STICH') {
                $uphasilconv->mesin3 = $request->mesin;
                $uphasilconv->hasil_baik_mesin3 = $request->hasil_baik;
                $uphasilconv->hasil_jelek_mesin3 = $request->hasil_jelek;

                $uphasilconv->save();
                
                return redirect('admin/plan/hasilconvstich');
            }  
            if ($request->mesin == 'TOKAI') {
                $uphasilconv->mesin2 = $request->mesin;
                $uphasilconv->hasil_baik_mesin2 = $request->hasil_baik;
                $uphasilconv->hasil_jelek_mesin2 = $request->hasil_jelek;

                $uphasilconv->save();
                
                return redirect('admin/plan/hasilconvtokai');
            }  
            if ($request->mesin == 'SLITTER') {
                $uphasilconv->mesin5 = $request->mesin;
                $uphasilconv->hasil_baik_mesin5 = $request->hasil_baik;
                $uphasilconv->hasil_jelek_mesin5 = $request->hasil_jelek;

                $uphasilconv->save();
                
                return redirect('admin/plan/hasilconvslitter');
            }  
            if ($request->mesin == 'WAX') {
                $uphasilconv->mesin4 = $request->mesin;
                $uphasilconv->hasil_baik_mesin4 = $request->hasil_baik;
                $uphasilconv->hasil_jelek_mesin4 = $request->hasil_jelek;

                $uphasilconv->save();
                
                return redirect('admin/plan/hasilconvwax');
            }   
            if ($request->mesin == 'GLUE MANUAL') {
                $uphasilconv->mesin6 = $request->mesin;
                $uphasilconv->hasil_baik_mesin6 = $request->hasil_baik;
                $uphasilconv->hasil_jelek_mesin6 = $request->hasil_jelek;

                $uphasilconv->save();
                
                return redirect('admin/plan/hasilconvglue');
            }   
        } else {
            if ($request->mesin == 'FLEXO') {
                $createhasilconv = HasilConv::create([
                    'plan_conv_m_id' => $request->planmid,
                    'plan_conv_d_id' => $request->plandid,
                    'noOpi' => $request->noopi,
                    'jml_Order' => $request->plan,
                    'mesin1' => $request->mesin,
                    'hasil_baik_mesin1' => $request->hasil_baik,
                    'hasil_jelek_mesin1' => $request->hasil_jelek
                ]);

                return redirect('admin/plan/hasilconvflexo');
            }
            if ($request->mesin == 'WAX') {
                $createhasilconv = HasilConv::create([
                    'plan_conv_m_id' => $request->planmid,
                    'plan_conv_d_id' => $request->plandid,
                    'noOpi' => $request->noopi,
                    'jml_Order' => $request->plan,
                    'mesin4' => $request->mesin,
                    'hasil_baik_mesin4' => $request->hasil_baik,
                    'hasil_jelek_mesin4' => $request->hasil_jelek
                ]);

                
                return redirect('admin/plan/hasilconvwax');
            }
            if ($request->mesin == 'TOKAI') {
                $createhasilconv = HasilConv::create([
                    'plan_conv_m_id' => $request->planmid,
                    'plan_conv_d_id' => $request->plandid,
                    'noOpi' => $request->noopi,
                    'jml_Order' => $request->plan,
                    'mesin2' => $request->mesin,
                    'hasil_baik_mesin2' => $request->hasil_baik,
                    'hasil_jelek_mesin2' => $request->hasil_jelek
                ]);
                return redirect('admin/plan/hasilconvtokai');
            }
            if ($request->mesin == 'STICHING') {
                $createhasilconv = HasilConv::create([
                    'plan_conv_m_id' => $request->planmid,
                    'plan_conv_d_id' => $request->plandid,
                    'noOpi' => $request->noopi,
                    'jml_Order' => $request->plan,
                    'mesin3' => $request->mesin,
                    'hasil_baik_mesin3' => $request->hasil_baik,
                    'hasil_jelek_mesin3' => $request->hasil_jelek
                ]);
                return redirect('admin/plan/hasilconvstich');
            }
            if ($request->mesin == 'SLITTER') {
                $createhasilconv = HasilConv::create([
                    'plan_conv_m_id' => $request->planmid,
                    'plan_conv_d_id' => $request->plandid,
                    'noOpi' => $request->noopi,
                    'jml_Order' => $request->plan,
                    'mesin5' => $request->mesin,
                    'hasil_baik_mesin5' => $request->hasil_baik,
                    'hasil_jelek_mesin5' => $request->hasil_jelek
                ]);
                
                return redirect('admin/plan/hasilconvslitter');
            }
            if ($request->mesin == 'GLUE MANUAL') {
                $createhasilconv = HasilConv::create([
                    'plan_conv_m_id' => $request->planmid,
                    'plan_conv_d_id' => $request->plandid,
                    'noOpi' => $request->noopi,
                    'jml_Order' => $request->plan,
                    'mesin5' => $request->mesin,
                    'hasil_baik_mesin6' => $request->hasil_baik,
                    'hasil_jelek_mesin6' => $request->hasil_jelek
                ]);
                
                return redirect('admin/plan/hasilconvglue');
            }
            
        }
    }

    public function control() 
    {
        $control = HasilConv::get();

        dd($control);

        return view('admin.plan.hasilconv.control', compact('control'));
    }
}
