<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Marketing\FormMc as MarketingFormMc;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FormMc extends Controller
{
    public function getListMc()
    {
        $list = MarketingFormMc::orderBy('kode', 'Desc');

        return DataTables::of($list)->toJson();
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

        $kode = (int)filter_var($mc->kode, FILTER_SANITIZE_NUMBER_INT) + 1;

        MarketingFormMc::create([
            'kode' => "MC".$kode,
            'customer' => $request->cust,
            'barang' => $request->barang,
            'keterangan' => $request->keterangan,
            'createdBy' => $request->createdBy
        ]);

        return redirect('admin/marketing/formmc')->with('success', "Data Berhasil disimpan dengan kode = MC".$kode);
    }
}
