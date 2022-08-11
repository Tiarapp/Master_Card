<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DTController extends Controller
{
    public function index()
    {
        $dt = DeliveryTime::orderBy('kontrak_m_id','desc')->get();
        
        return view('admin.dt.index', compact('dt'));
    }

    public function edit($id)
    {
        $dt = DeliveryTime::findOrFail($id);

        return view('admin.dt.edit', ['dt' => $dt]);
    }

    public function update(Request $request,$id)
    {
        $dt = DeliveryTime::findOrFail($id);

        $dt->dt_perubahan = $request->dt_perubahan;
        $dt->pcsDt = $request->pcsDt;
        
        if (Auth::user()->divisi_id == 5) {
            $dt->approve_ppic = 1;
        } else if (Auth::user()->divisi_id == 3) {
            $dt->approve_mkt = 1;
        }

        $dt->save();

        return redirect('admin/dt')->with('success', "Data Berhasil di Update dengan kode Kontrak = ". $request->kontrak." dan tanggal kirim ". $request->dt_peruabahan ." dan Qty = ". $request->pcsDt);
    }

    public function approve($id)
    {
        $dt = DeliveryTime::findOrFail($id);

        if (Auth::user()->divisi_id == 5  && $dt->approve_ppic != 1) {
            $dt->approve_ppic = 1;
            $user = Auth::user()->name." PPIC";

            $dt->save();
    
            return redirect('admin/dt')->with('success', "Data berhasil di Approve oleh ".$user);
            
        } else 
        if (Auth::user()->divisi_id == 5  && $dt->approve_ppic == 1) { 
            return redirect('admin/dt')->with('success', "PPIC sudah Approve, mohon mengajukan Approve ke Marketing!");
        } else
        if (Auth::user()->divisi_id == 3 && $dt->approve_mkt != 1) {
            $dt->approve_mkt = 1;
            $user = Auth::user()->name." Marketing";

            $dt->save();
    
            return redirect('admin/dt')->with('success', "Data berhasil di Approve oleh ".$user);
        } else 
        if (Auth::user()->divisi_id == 3 && $dt->approve_mkt == 1) {
            return redirect('admin/dt')->with('success', "Marketing sudah Approve, mohon mengajukan Approve ke PPIC!");
        }
    }

    public function destroy($id)
    {
        $dt = DeliveryTime::find($id);
        $dt->delete();

        return redirect('admin/dt')->with('success', "Data Berhasil dihapus");


    }
}
