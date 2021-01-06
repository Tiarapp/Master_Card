<?php

namespace App\Http\Controllers;

use App\Models\BoxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoxTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxtype = DB::table('tipe_box')
            ->where('deleted', '=', '0')
            ->get();
        return view('admin.boxtype.index', ['boxtype' => $boxtype]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.boxtype.create');
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
            'createdBy' => 'required',
            'branch' => 'required'
        ]);

        BoxType::create($request->all());

        return redirect('admin/boxtype');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BoxType  $boxType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boxtype = BoxType::find($id);

        return view('admin.boxtype.show', ['boxtype' => $boxtype]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BoxType  $boxType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boxtype = BoxType::find($id);

        return view('admin.boxtype.edit', ['boxtype' => $boxtype]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BoxType  $boxType
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

        $boxtype = BoxType::find($id);

        $boxtype->kode = $request->kode;
        $boxtype->nama = $request->nama;
        $boxtype->branch = $request->branch;
        $boxtype->lastUpdatedBy = $request->lastUpdatedBy;

        $boxtype->save();

        return redirect('admin/boxtype');
    }

    public function updateDeleted($id)
    {
        $boxtype = BoxType::find($id);

        $boxtype->deleted = 1;
        $boxtype->deletedAt = date('Y-m-d h:i:s');
        $boxtype->deletedBy = Auth::user()->name;

        $boxtype->save();

        return redirect('/admin/boxtype');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BoxType  $boxType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoxType $boxType)
    {
        //
    }
}
