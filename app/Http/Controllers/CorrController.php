<?php

namespace App\Http\Controllers;

use App\Models\Corr_D;
use App\Models\Corr_M;
use App\Models\Opi_M;
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
        $data = Corr_D::get();
        return Datatables::of($data)->make(true);
    }

    public function corrd(Request $request)
    {
        if ($request->ajax()) {
            $data = Corr_D::corr()->unique('id')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../admin/plan/corr/edit/".$row->id."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../admin/plan/corr/print/".$row->id."' class='btn btn-outline-secondary' type='button'>Print</a>";

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
     
                        $btn = "<a href='../admin/plan/corr/edit/".$row->id."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../admin/plan/corr/print/".$row->id."' class='btn btn-outline-secondary' type='button'>Print</a>";

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
                'kode_plan_d' => $request->kodeplan[$i],
                'urutan' => $request->urutan[$i],
                'sheet_p' => $request->sheetp[$i],
                'sheet_l' => $request->sheetl[$i],
                'flute' => $request->flute[$i],
                'bentuk' => $request->tipebox[$i],
                'out_corr' => $request->outCorr[$i],
                'out_flexo' => $request->outFlexo[$i],
                'qtyOrder' => $request->plan[$i],
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
