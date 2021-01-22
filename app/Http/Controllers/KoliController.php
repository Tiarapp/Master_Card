<?php

namespace App\Http\Controllers;

use App\Models\Koli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $koli = DB::table('koli')->get();

        return view('admin.koli.index', compact('koli'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = DB::table('satuan')->get();

        return view('admin.koli.create', compact('satuan'));
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
            'qtyBox' => 'required',
            'createdBy' => 'required'
        ]);

        Koli::create($request->all());

        return redirect('admin/koli');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Koli  $koli
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $koli = Koli::find($id);

        return view('admin.koli.show', compact('koli'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Koli  $koli
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $satuan = DB::table('satuan')->get();
        $koli = Koli::find($id);

        return view('admin.koli.edit', compact('koli','satuan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Koli  $koli
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'qtyBox' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $koli = Koli::find($id);

        $koli->kode = $request->kode;
        $koli->nama = $request->nama;
        $koli->qtyBox = $request->qtyBox;
        $koli->satuanBox = $request->satuanBox;
        $koli->lastUpdatedBy = $request->lastUpdatedBy;

        $koli->save();

        return redirect('admin/koli');
    }

    public function updateDeleted($id)
    {
        $koli = Koli::find($id);

        $koli->deleted = 1;
        $koli->deletedAt = date('Y-m-d h:i:s');
        $koli->deletedBy = Auth::user()->name;

        $koli->save();

        return redirect('/admin/box');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Koli  $koli
     * @return \Illuminate\Http\Response
     */
    public function destroy(Koli $koli)
    {
        //
    }
}
