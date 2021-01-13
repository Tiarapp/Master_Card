<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisi = DB::table('divisi')
            ->where('deleted', '=', '0')
            ->simplePaginate(25);
        
        return view('admin.divisi.index', compact('divisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.divisi.create');
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
            'createdBy' => 'required'
        ]);

        Divisi::create($request->all());

        return redirect('/admin/divisi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $divisi = Divisi::find($id);

        return view('admin.divisi.show', ['divisi' => $divisi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $divisi = Divisi::find($id);

        return view('admin.divisi.edit', ['divisi' => $divisi]);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'branch' => 'required',
            'lastUpdatedBy' => 'required'
        ]);

        $divisi = Divisi::find($id);

        $divisi->nama = $request->nama;
        $divisi->branch = $request->branch;
        $divisi->lastUpdatedBy = Auth::user()->name;

        $divisi->save();

        return redirect('/admin/divisi')
            ->with('success', 'Update Success');
    }
    
    public function updateDeleted($id)
    {
        $divisi = Divisi::find($id);

        $divisi->deleted = 1;
        $divisi->deletedAt = date('Y-m-d h:i:s');
        $divisi->deletedBy = Auth::user()->name;

        $divisi->save();

        return redirect('/admin/divisi');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Divisi $divisi)
    {
        //
    }
}
