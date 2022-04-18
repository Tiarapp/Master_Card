<?php

namespace App\Http\Controllers;

use App\Models\BBK_Roll;
use App\Models\BBM_Roll;
use App\Models\Retur_BBK_Roll;
use App\Models\Roll_D;
use App\Models\Roll_M;
use App\Models\SuppRoll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rolld = Roll_D::all();

        // dd($rolld->bbk);

        return view('admin.roll.index', compact('rolld'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        // dd($kode_internal);

        // $request->validate([
        //     'tgl_bbm'           => 'required|date',
        //     'berat_sj'          => 'required|numeric',
        //     'berat_timbang'     => 'required|numeric',
        //     'no_po'             => 'nullable',
        //     'gsm_actual'        => 'required|numeric',
        //     'cobsize_top'       => 'numeric|nullable',
        //     'cobsize_back'      => 'numeric|nullable',
        // ]);

        // dd($request->tgl_bbm);

        $rolld = Roll_D::create([
            'kode_roll'         => $request->kode_roll,
            'supp_id'           => $request->supp,
            'kode_internal'     => $kode_internal,
            'gsm_actual'        => $request->gsm_actual,
            'cobsize_top'       => $request->cobsizetop,
            'cobsize_back'      => $request->cobsizeback,
            'stok'              => $request->berattimbang,
            'roll_m_id'         => $request->rollm
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
        $rolld = Roll_D::find($id)->first();

        return view('admin.roll.bbk', compact('rolld'));
    }

    public function prosesBbk($id, Request $request)
    {
        $rolld = Roll_D::find($id)->first();

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

            // dd($rolld->stok);

            $rolld->save();

            // dd($rolld);
            return redirect('admin/roll')->with("succes", 'Bon Barang Keluar Berhasil disimpan !');
        }

    }

    public function returBbk($id)
    {
        $rolld = Roll_D::find($id)->first();

        return view('admin.roll.returbbk', compact('rolld'));
    }

    public function prosesRetur($id, Request $request)
    {
        $rolld = Roll_D::find($id)->first();

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
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roll_M  $roll_M
     * @return \Illuminate\Http\Response
     */
    public function show(Roll_M $roll_M)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roll_M  $roll_M
     * @return \Illuminate\Http\Response
     */
    public function edit(Roll_M $roll_M)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roll_M  $roll_M
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roll_M $roll_M)
    {
        //
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
