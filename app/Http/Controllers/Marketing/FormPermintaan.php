<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MemoMastercard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FormPermintaan extends Controller
{
    public function getPermintaan() 
    {
        $permintaan = MemoMastercard::orderBy('id', 'Desc');

        return DataTables::of($permintaan)->toJson();
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
            'createdBy' => Auth::user()->name 
        ]);

        return redirect('admin/marketing/formpermintaan')->with('success', "Data Berhasil disimpan dengan kode = ". $kode);
    }
}
