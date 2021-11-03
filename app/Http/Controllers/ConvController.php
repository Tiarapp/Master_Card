<?php

namespace App\Http\Controllers;

use App\Models\Conv_D;
use App\Models\Conv_M;
use App\Models\HasilCorr;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConvController extends Controller
{
    public function json()
    {
        $data = Conv_M::get();
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
     
                        $btn = "<a href='../plan/hasilcorr/edit/".$row->corrdid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../plan/hasilcorr/print/".$row->corrdid."' class='btn btn-outline-secondary' type='button'>Print</a>";

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
    public function index_conv()
    {
        return view('admin.plan.conv.flexoa');
    }

    public function createFlexoA()
    {
        $corr = HasilCorr::hasilcorr()->orderBy('next_mesin', 'asc')->get();

        // dd($corr);
        return view('admin.plan.conv.flexocreate', compact('corr'));
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
                'plan_corr_id' => $request->hasilcorrid[$i],
                'tgl_kirim' => $request->dt[$i],
                'nomc' => $request->mc[$i],
                'nama_item' => $request->item[$i],
                'customer' => $request->customer[$i],
                'tipe_order' => $request->tipeOrder[$i],
                'joint' => $request->finishing[$i],
                'wax' => $request->wax[$i],
                'mesin' => $request->mesin[$i],
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

            $uphasilcorr = HasilCorr::find($request->hasilcorrid[$i])->first();
            $uphasilcorr->sisa = $request->order[$i] - $request->plan[$i];

            $uphasilcorr->save();
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
        
        // dd($convd);
        return view('admin.plan.conv.pdf', compact('convm','convd'));
    }

    public function edit($id)
    {
        
        $hasilcorr = HasilCorr::hasilcorr()->get();
        $data1 = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->get();

        $data2 = Conv_M::where('plan_conv_m.id', '=', $id)->first();

        dd($data1);
        return view('admin.plan.conv.edit', compact('data1','data2','hasilcorr'));
    }
}
