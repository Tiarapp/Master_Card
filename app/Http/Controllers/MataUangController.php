<?php

namespace App\Http\Controllers;

use App\Models\MataUang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MataUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matauang = DB::table('mata_uang')
            ->where('deleted', '=', '0')
            ->get();
        return view('admin.matauang.index', ['matauang' => $matauang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.matauang.create');
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
            'branch' => 'required',
            'createdBy' => 'required',
        ]);

        MataUang::create($request->all());

        return redirect('/admin/matauang');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matauang = MataUang::find($id);

        return view('/admin/matauang/show', ['matauang' => $matauang]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matauang = MataUang::find($id);

        return view('admin/matauang/edit', ['matauang' => $matauang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'branch' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $mataUang = MataUang::find($id);

        $mataUang->kode = $request->kode;
        $mataUang->nama = $request->nama;
        $mataUang->branch = $request->branch;
        $mataUang->lastUpdatedBy = Auth::user()->name;

        $mataUang->save();

        return redirect('/admin/matauang');
    }

    public function updateDeleted($id)
    {
        $mataUang = MataUang::find($id);

        $mataUang->deleted = 1;
        $mataUang->deletedAt = date('Y-m-d h:i:s');
        $mataUang->lastUpdatedBy = Auth::user()->name;
        $mataUang->deletedBy = Auth::user()->name;

        $mataUang->save();

        return redirect('/admin/matauang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MataUang  $mataUang
     * @return \Illuminate\Http\Response
     */
    public function destroy(MataUang $mataUang)
    {
        //
    }
}
