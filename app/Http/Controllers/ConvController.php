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
        // $data = Conv_D::conv()->get();
        $data = HasilCorr::hasilcorr()->get();
        return DataTables::of($data)->make(true);
    }

    public function corrd(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_D::corr()->get();
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
    public function index_flexoA()
    {
        return view('admin.plan.conv.flexoa');
    }

    public function createFlexoA()
    {
        $corr = HasilCorr::hasilcorr()->get();

        // dd($corr);
        return view('admin.plan.conv.flexocreate', compact('corr'));
    }

    
    public function storeFlexoA(Request $request)
    {
        $convm = Conv_M::create([   
            'kode' => $request->kodeplan,
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
                'kode_plan_d' => $request->kodeplan[$i],
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
                'cop' => $request->cop[$i],
                'trim_waste' => $request->trim[$i],
                'rm_order' => $request->rmorder[$i],
                'tonase' => $request->beratOrder[$i],
                'kebutuhan_kertasAtas' => $request->kebutuhanAtas[$i],
                'kebutuhan_kertasFlute1' => $request->kebutuhanFlute1[$i],
                'kebutuhan_kertasTengah' => $request->kebutuhanTengah[$i],
                'kebutuhan_kertasFlute2' => $request->kebutuhanFlute2[$i],
                'kebutuhan_kertasBawah' => $request->kebutuhanBawah[$i],
                'keterangan' => $request->keterangan[$i],
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

    public function flexoa_pdf()
    {
        $corr = HasilCorr::get();

        return view('admin.plan.conv.pdf', compact('corr'));
    }
}
