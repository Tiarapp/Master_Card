<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sheet = DB::table('sheet')->get();

        return view('admin.sheet.index', compact('sheet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = DB::table('satuan')->get();
        
        return view('admin.sheet.create', compact('satuan'));
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
            'lebarSheet' => 'numeric',
            'panjangSheet' => 'numeric',
            'satuanSizeSheet' => 'numeric',
            'luasSheet' => 'numeric',
            'satuanLuasSheet' => 'numeric',
            'createdBy' => 'required',

        ]);

        Sheet::create($request->all());

        return redirect('admin/sheet');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sheet = Sheet::find($id);

        return view('admin.sheet.show', ['sheet' => $sheet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sheet = Sheet::find($id);

        return view('admin.sheet.edit', ['sheet' => $sheet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'lebarSheet' => 'numeric',
            'panjangSheet' => 'numeric',
            'satuanSizeSheet' => 'numeric',
            'luasSheet' => 'numeric',
            'satuanLuasSheet' => 'numeric',
            'lastUpdatedBy' => 'required',
        ]);

        $sheet = Sheet::find($id);

        $sheet->kode = $request->kode;
        $sheet->nama = $request->nama;
        $sheet->lebarSheet = $request->lebarSheet;
        $sheet->panjangSheet = $request->panjangSheet;
        $sheet->satuanSizeSheet = $request->satuanSizeSheet;
        $sheet->luasSheet = $request->luasSheet;
        $sheet->satuanLuasSheet = $request->satuanLuasSheet;
        $sheet->lastUpdatedBy = $request->lastUpdatedBy;

        $sheet->save();

        return redirect('admin/sheet');
    }

    public function updateDeleted($id)
    {
        $sheet = Sheet::find($id);

        $sheet->deleted = 1;
        $sheet->deletedAt = date('Y-m-d h:i:s');
        $sheet->lastUpdatedBy = Auth::user()->name;
        $sheet->deletedBy = Auth::user()->name;

        $sheet->save();

        return redirect('/admin/sheet');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sheet $sheet)
    {
        //
    }
}
