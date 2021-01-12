<?php

namespace App\Http\Controllers;

use App\Models\Substance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $substance = DB::table('substance')
            ->leftJoin('jenis_gram as linerAtas', 'jenisGramLinerAtas_id', '=', 'linerAtas.id')
            ->leftJoin('jenis_gram as bf', 'jenisGramBf_id', '=', 'bf.id')
            ->leftJoin('jenis_gram as linerTengah', 'jenisGramLinerTengah_id', '=', 'linerTengah.id')
            ->leftJoin('jenis_gram as cf', 'jenisGramCf_id', '=', 'cf.id')
            ->leftJoin('jenis_gram as linerBawah', 'jenisGramLinerBawah_id', '=', 'linerBawah.id')
            ->select('substance.*', 'linerAtas.nama', 'bf.nama', 'linerTengah.nama', 'cf.nama', 'linerBawah.nama')
            ->get();

        return view('admin.substance.index', ['substance' => $substance]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisgram = DB::table('jenis_gram')->get();

        return view('admin.substance.create', compact('jenisgram'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function show(Substance $substance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function edit(Substance $substance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Substance $substance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Substance $substance)
    {
        //
    }
}
