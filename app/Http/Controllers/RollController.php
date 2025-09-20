<?php

namespace App\Http\Controllers;

use App\Models\BBK_Roll;
use App\Models\BBM_Roll;
use App\Models\Retur_BBK_Roll;
use App\Models\Roll_D;
use App\Models\Roll_M;
use App\Models\RollInventory;
use App\Models\SuppRoll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rollinventories = RollInventory::all();

        // dd($rolld->bbk);

        return view('admin.roll.index', compact('rollinventories'));
    }

    public function indexBbm()
    {
        // $bbm = BBM_Roll::all();

        return view('admin.roll.indexbbm');
    }

    public function bbmRoll()
    {
        $rolld = Roll_D::all();
        $rollm = Roll_M::all();
        $suppliers = SuppRoll::all();

        return view('admin.roll.bbm', compact('rolld','suppliers','rollm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supp = SuppRoll::find($request->supp);

        $kode_internal = $supp->kode_supp."".str_pad($supp->numb_seq, 4, '0', STR_PAD_LEFT);   

        $rolld = Roll_D::create([
            'kode_roll'         => $request->kode_roll,
            'supp_id'           => $request->supp,
            'kode_internal'     => $kode_internal,
            'gsm_actual'        => $request->gsm_actual,
            'cobsize_top'       => $request->cobsizetop,
            'cobsize_back'      => $request->cobsizeback,
            'stok'              => $request->berattimbang,
            'roll_m_id'         => $request->rollm,
            'created_by'        => Auth::user()->name
        ]);

        $bbm = BBM_Roll::create([
            'roll_d_id'         => $rolld->id,
            'tgl_bbm'           => $request->tglbbm,
            'berat_sj'          => $request->beratsj,
            'berat_timbang'     => $request->berattimbang,
            'no_po'             => $request->nopo,
            'created_by'        => Auth::user()->name
        ]);

        
        $supp->numb_seq = $supp->numb_seq+1;

        $supp->save();

        // dd($supp->numb_seq);

        return redirect('admin/roll')->with('succes', 'Data Berhasil disimpan!! dengan kode Internal : '.$kode_internal);

    }

    public function bbk($id)
    {
        $rolld = Roll_D::find($id);

        // dd($rolld);

        return view('admin.roll.bbk', compact('rolld'));
    }

    public function prosesBbk($id, Request $request)
    {
        $rolld = Roll_D::find($id);

        if ($request->qty > $rolld->stok) {
            return redirect('admin/roll/bbk/'.$id)->with('succes', 'Qty BBK tidak boleh lebih besar dari QTY Real');
        } else {
            $bbk = BBK_Roll::create([
                'roll_d_id'     => $id,
                'tgl_bbk'       => $request->tglbbk,
                'No_OPI'        => $request->noopi,
                'subs'          => $request->subs,
                'bbk'           => $request->qty,
                'created_by'    => Auth::user()->name
            ]);
            
            $rolld->stok = $rolld->stok - $request->qty;
            // $rolld->is_edit = 1;

            $rolld->save();

            return redirect('admin/roll')->with("succes", 'Bon Barang Keluar Berhasil disimpan !');
        }

    }

    public function returBbk($id)
    {
        $rolld = Roll_D::find($id);

        return view('admin.roll.returbbk', compact('rolld'));
    }

    public function prosesRetur($id, Request $request)
    {
        $rolld = Roll_D::find($id);

        $returbbk = Retur_BBK_Roll::create([
            'roll_d_id'     => $id,
            'tgl_retur'     => $request->tglretur,
            'qty_retur'     => $request->qty,
            'Created_by'    => Auth::user()->name
        ]);

        $rolld->stok = $rolld->stok + $request->qty;

        $rolld->save();

        return redirect('admin/roll')->with('succes', 'Retur Berhasil disimpan!!');
    }
    
    public function edit(Roll_M $roll_M, $id)
    {

        $roll = Roll_D::find($id);
        $suppliers = SuppRoll::all();
        $rollm = Roll_M::all();
        // dd($roll->is_edit === 1);
       if ($roll->is_edit === 1) {
            Alert::error('Error', 'BBM sudah ada transaksi, Mohon hubungi Admin');
            return redirect('admin/roll/bbm')->with('error','A');
       } else {
            return view('admin.roll.edit', compact('roll', 'suppliers', 'rollm'));
       }

    }

    public function update(Request $request, $id)
    {
        $updateDetail = Roll_D::find($id);
        
        $updateDetail->kode_roll = $request->kode_roll;
        $updateDetail->roll_m_id = $request->rollm;
        $updateDetail->supp_id = $request->supp;
        $updateDetail->gsm_actual = $request->gsm_actual;
        $updateDetail->cobsize_top = $request->cobsizetop;
        $updateDetail->cobsize_back = $request->cobsizeback;
        $updateDetail->stok = $request->berattimbang;

        $updateDetail->save();

        $updateBBM = BBM_Roll::where('roll_d_id', $updateDetail->id)->first();

        // dd($updateDetail);

        $updateBBM->tgl_bbm = $request->tglbbm;
        $updateBBM->berat_sj = $request->beratsj;
        $updateBBM->berat_timbang = $request->berattimbang;
        $updateBBM->no_po = $request->nopo;

        $updateBBM->save();


        return redirect('admin/roll/bbm')->with('succes', 'Data Berhasil Di Update!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roll_M  $roll_M
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roll_M $roll_M)
    {
        //
    }
}
