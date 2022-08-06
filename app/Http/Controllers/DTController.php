<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use Illuminate\Http\Request;

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

        $dt->save();

        return redirect('admin/dt')->with('success', "Data Berhasil di Update dengan kode Kontrak = ". $request->kontrak." dan tanggal kirim ". $request->dt_peruabahan ." dan Qty = ". $request->pcsDt);
    }
}
