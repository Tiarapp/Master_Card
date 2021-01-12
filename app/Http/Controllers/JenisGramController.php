<?php

namespace App\Http\Controllers;

use App\Models\JenisGram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JenisGramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisgram = DB::table('jenis_gram')->get();

        return view('admin.jenisgram.index', compact('jenisgram'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jenisgram.create');
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
            'jenisKertas' => 'required',
            'gramKertas' => 'required',
            'createdBy' => 'required',
        ]);

        JenisGram::create($request->all());

        return redirect('admin/jenisgram');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisGram  $jenisGram
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenisgram = JenisGram::find($id);

        return view('admin.jenisgram.show', ['jenisgram' => $jenisgram]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisGram  $jenisGram
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenisgram = JenisGram::find($id);

        return view('admin.jenisgram.edit', ['jenisgram' => $jenisgram]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisGram  $jenisGram
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'jenisKertas' => 'required',
            'gramKertas' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $jenisgram = JenisGram::find($id);

        $jenisgram->kode = $request->kode;
        $jenisgram->nama = $request->nama;
        $jenisgram->jenisKertas = $request->jenisKertas;
        $jenisgram->gramKertas = $request->gramKertas;
        $jenisgram->lastUpdatedBy = $request->lastUpdatedBy;

        $jenisgram->save();

        return redirect('admin/jenisgram');
    }

    public function updateDeleted($id)
    {
        $jenisgram = JenisGram::find($id);

        $jenisgram->deleted = 1;
        $jenisgram->deletedAt = date('Y-m-d h:i:s');
        $jenisgram->lastUpdatedBy = Auth::user()->name;
        $jenisgram->deletedBy = Auth::user()->name;

        $jenisgram->save();

        return redirect('/admin/jenisgram');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisGram  $jenisGram
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisGram $jenisGram)
    {
        //
    }
}
