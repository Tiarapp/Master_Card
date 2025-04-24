<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Marketing\FormMc as MarketingFormMc;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FormMc extends Controller
{
    public function getListMc()
    {
        $list = MarketingFormMc::orderBy('kode', 'Desc'); 
        
        return DataTables::of($list)
            ->addColumn('action', function($list) {
                return '<a href="../marketing/formmc/edit/'. $list->kode .'" class="btn btn-primary"> Edit </a>';
            })
            ->addColumn('date_entry', function($permintaan) {
                return date_format(date_create($permintaan->created_at), 'd-m-Y');
            })
        ->make(true);
    }

    public function list()
    {
        return view('admin.Marketing.formmc');
    }

    public function add()
    {
        return view('admin.Marketing.addFormMc');
    }

    public function store(Request $request)
    {
        $mc = MarketingFormMc::orderBy('kode', 'Desc')->first();

        preg_match_all('!\d+!', $mc->kode, $kode);

        $res = ((int) $kode[0][0]) + 1;

        MarketingFormMc::create([
            'kode' => "MC".$res,
            'customer' => $request->cust,
            'barang' => $request->barang,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::user()->name
        ]);

        Tracking::create([
            'user' => Auth::user()->name,
            'event' => 'Tambah Form Mastercard MC'.$res
        ]);
        return redirect('admin/marketing/formmc')->with('success', "Data Berhasil disimpan dengan kode = MC".$res);
    }

    public function edit($kode)
    {
        $form = MarketingFormMc::where('kode', $kode)->first();

        return view('admin.Marketing.editFormMC', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = MarketingFormMc::where('kode', $id)->first();

        $form->customer = $request->input('customer');
        $form->barang = $request->input('barang');
        $form->updated_by = Auth::user()->name;

        $form->save();

        Tracking::create([
            'user' => Auth::user()->name,
            'event' => 'Update Form Mastercard '.$form->kode
        ]);

        return redirect('/admin/marketing/formmc')->with('success', 'Data berhasil diubah !!');
    }
}
