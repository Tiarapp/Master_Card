<?php

namespace App\Http\Controllers;

use App\Models\Warna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warna = DB::table('color')
            ->orderBy('id', 'desc')
            // ->orderBy('mudaTua', 'asc')
            ->get();

        return view('admin.warna.index', ['warna' => $warna]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.warna.create');
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
            'mudaTua' => 'numeric',
            'createdBy' => 'required',
            'branch' => 'required'
        ]);

        Warna::create($request->all());

        return redirect('admin/warna');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warna  $warna
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warna = Warna::find($id);

        return view('admin.warna.show', ['warna' => $warna]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warna  $warna
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warna = Warna::find($id);

        return view('admin.warna.edit', ['warna' => $warna]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warna  $warna
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'mudaTua' => 'numeric',
            'lastUpdatedBy' => 'required',
            'branch' => 'required'
        ]);

        $warna = Warna::find($id);

        $warna->kode = $request->kode;
        $warna->nama = $request->nama;
        $warna->mudaTua = $request->mudaTua;
        $warna->branch = $request->branch;
        $warna->lastUpdatedBy = $request->lastUpdatedBy;

        $warna->save();

        return redirect('admin/warna');
    }


    public function updateDeleted($id)
    {
        $warna = Warna::find($id);

        $warna->deleted = 1;
        $warna->deletedAt = date('Y-m-d h:i:s');
        $warna->lastUpdatedBy = Auth::user()->name;
        $warna->deletedBy = Auth::user()->name;

        $warna->save();

        return redirect('/admin/warna');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warna  $warna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warna $warna)
    {
        //
    }
}
