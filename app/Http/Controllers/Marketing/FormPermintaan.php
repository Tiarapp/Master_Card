<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MemoMastercard;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FormPermintaan extends Controller
{
    public function getPermintaan() 
    {
        $permintaan = MemoMastercard::orderBy('id', 'Desc');

        return DataTables::of($permintaan)
            ->addColumn('action', function($permintaan){
                return '<a href="/admin/marketing/formpermintaan/edit/'.$permintaan->id.'" class="btn btn-primary"> Edit </a>';
            })
            ->make(true);
    }

    public function listPermintaan()
    {
        return view('admin.Marketing.formpermintaan');
    }

    public function add()
    {
        return view('admin.Marketing.addpermintaan');
    }

    public function store(Request $request)
    {
        $getLastID = MemoMastercard::orderBy('id', 'Desc')->first();

        $kode = $getLastID->id +1;

        MemoMastercard::create([
            'id' => $kode,
            'tanggal' => $request->tanggal,
            'customer' => $request->cust,
            'barang' => $request->barang,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::user()->name 
        ]);

        Tracking::create([
            'user' => Auth::user()->name,
            'event' => 'Tambah Form Permintaan '.$kode
        ]);
        return redirect('admin/marketing/formpermintaan')->with('success', "Data Berhasil disimpan dengan kode = ". $kode);
    }

    public function edit($id)
    {
        $memo = MemoMastercard::find($id);

        return view('admin.Marketing.editPermintaan', compact('memo'));
    }

    public function update(Request $request, $id)
    {
        $memo = MemoMastercard::where('id', $id)->first();

        $memo->tanggal = $request->input('tanggal');
        $memo->customer = $request->input('customer');
        $memo->barang = $request->input('barang');
        $memo->keterangan = $request->input('keterangan');
        $memo->updated_by = Auth::user()->name;

        $memo->save();
        Tracking::create([
            'user' => Auth::user()->name,
            'event' => 'Update Form Permintaan '.$id
        ]);

        return redirect('/admin/marketing/formpermintaan')->with('success', 'Data berhasil diubah!!');
    }
}
