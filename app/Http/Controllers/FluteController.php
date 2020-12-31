<?php

namespace App\Http\Controllers;

use App\Models\Flute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FluteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flute = DB::table('flute')
            ->where('deleted', '=', '0')
            ->get();

        return view('admin.flute.index', compact('flute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.flute.create');
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
            'tur' => 'required|numeric',
            'branch' => 'required',
            'createdBy' => 'required'
        ]);

        Flute::create($request->all());

        return redirect('admin/flute');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flute  $flute
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flute = Flute::find($id);

        return view('admin.flute.show', ['flute' => $flute]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flute  $flute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flute = Flute::find($id);

        return view('admin.flute.edit', ['flute' => $flute]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flute  $flute
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'tur' => 'required|numeric',
            'branch' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $flute = Flute::find($id);

        $flute->nama = $request->nama;
        $flute->tur = $request->tur;
        $flute->branch = $request->branch;
        $flute->lastUpdatedBy = Auth::user()->name;

        $flute->save();

        return redirect('admin/flute');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flute  $flute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flute $flute)
    {
        //
    }
}
