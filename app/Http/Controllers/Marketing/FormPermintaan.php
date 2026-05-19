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
                return '<a href="../marketing/formpermintaan/edit/'.$permintaan->id.'" class="btn btn-primary"> Edit </a>';
            })
            ->addColumn('date_entry', function($permintaan) {
                return date_format(date_create($permintaan->created_at), 'd-m-Y');
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
        $periode = date('Y');
        $getLastID = MemoMastercard::where('tanggal', 'LIKE', $periode.'%')->get();
        
        $kode = str_pad(count($getLastID)+1,4, '0', STR_PAD_LEFT) ;

        MemoMastercard::create([
            'nomer' => $kode,
            'tanggal' => $request->tanggal,
            'customer' => $request->cust,
            'barang' => $request->barang,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::user()->name 
        ]);

        Tracking::create([
            'user'   => Auth::user()->name,
            'tipe'   => 'Form Permintaan',
            'event'  => 'Tambah Form Permintaan '.$kode,
            'before' => '-',
            'after'  => 'Kode: '.$kode.', Customer: '.$request->cust.', Barang: '.$request->barang,
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
        $old_customer_perm = $memo->customer;
        $old_barang_perm   = $memo->barang;
        $before_perm = json_encode([
            'tanggal'    => $memo->tanggal,
            'customer'   => $memo->customer,
            'barang'     => $memo->barang,
            'keterangan' => $memo->keterangan,
        ]);

        $memo->tanggal = $request->input('tanggal');
        $memo->customer = $request->input('customer');
        $memo->barang = $request->input('barang');
        $memo->keterangan = $request->input('keterangan');
        $memo->updated_by = Auth::user()->name;

        $memo->save();
        Tracking::create([
            'user'   => Auth::user()->name,
            'tipe'   => 'Form Permintaan',
            'event'  => 'Update Form Permintaan '.$id,
            'before' => $before_perm,
            'after'  => json_encode([
                'tanggal'    => $request->input('tanggal'),
                'customer'   => $request->input('customer'),
                'barang'     => $request->input('barang'),
                'keterangan' => $request->input('keterangan'),
            ]),
        ]);

        return redirect('/admin/marketing/formpermintaan')->with('success', 'Data berhasil diubah!!');
    }
}
