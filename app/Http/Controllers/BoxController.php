<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $box = Box::get();

        return view('admin.box.index', ['box' => $box]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipebox = DB::table('tipe_box')->get();

        return view('admin.box.create', compact('tipebox'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'boxtpie_id' => 'required',
            'tipeCreasCorr' => 'required',
            'lebarSheetCorr' => 'required|numeric',
            'panjangSheetBox' => 'required|numeric',
            'tinggiSheetBox' => 'required|numeric',
            'satuanSizeSheetBox' => 'required',
            'luasSheetBox' => 'required|numeric',
            'satuanLuasSheetBox' => 'required',
            'gramSheetBox' => 'required',
            'panjangDalamBox' => 'required',
            'lebarDalamBox' => 'required',
            'tinggiDalamBox' => 'required',
            'satuanSizeDalamBox' => 'required',
            'sizeCreasCorr' => 'required',
            'sizeCreasConv' => 'required',
            'satuanCreas' => 'required',
            'createdBy' => 'required'
        ]);

        Box::create($request->all());

        return redirect('admin/box');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $box = Box::find($id);

        return view('admin.box.show', ['box' => $box]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipebox = DB::table('tipe_box')->get();
        $box = Box::find($id);

        return view('admin.box.show', ['box' => $box], compact('tipebox'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'boxtpie_id' => 'required',
            'tipeCreasCorr' => 'required',
            'lebarSheetCorr' => 'required|numeric',
            'panjangSheetBox' => 'required|numeric',
            'tinggiSheetBox' => 'required|numeric',
            'satuanSizeSheetBox' => 'required',
            'luasSheetBox' => 'required|numeric',
            'satuanLuasSheetBox' => 'required',
            'gramSheetBox' => 'required',
            'panjangDalamBox' => 'required',
            'lebarDalamBox' => 'required',
            'tinggiDalamBox' => 'required',
            'satuanSizeDalamBox' => 'required',
            'sizeCreasCorr' => 'required',
            'sizeCreasConv' => 'required',
            'satuanCreas' => 'required',
            'lastUpdatedBy' => 'required'
        ]);

        $box = Box::find($id);

        $box->kode = $request->kode;
        $box->nama = $request->nama;
        $box->tipebox_id = $request->tipebox_id;
        $box->tipeCreasCorr = $request->tipeCreasCorr;
        $box->lebarSheetCorr = $request->lebarSheetCorr;
        $box->panjangSheetBox = $request->panjangSheetBox;
        $box->tinggiSheetBox = $request->tinggiSheetBox;
        $box->satuanSizeSheetBox = $request->satuanSizeSheetBox;
        $box->luasSheetBox = $request->luasSheetBox;
        $box->satuanLuasSheetBox = $request->satuanLuasSheetBox;
        $box->gramSheetBox = $request->gramSheetBox;
        $box->panjangDalamBox = $request->panjangDalamBox;
        $box->lebarDalamBox = $request->lebarDalamBox;
        $box->tinggiDalamBox = $request->tinggiDalamBox;
        $box->satuanSizeDalamBox = $request->satuanSizeDalamBox;
        $box->sizeCreasCorr = $request->sizeCreasCorr;
        $box->sizeCreasConv = $request->sizeCreasConv;
        $box->satuanCreas = $request->satuanCreas;
        $box->lastUpdatedBy = $request->lastUpdatedBy;

        $box->save();

        return redirect('admin/box');
    }

    public function updateDeleted($id)
    {
        $box = Box::find($id);

        $box->deleted = 1;
        $box->deletedAt = date('Y-m-d h:i:s');
        $box->deletedBy = Auth::user()->name;

        $box->save();

        return redirect('/admin/box');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        //
    }
}
