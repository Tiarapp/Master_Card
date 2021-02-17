<?php

namespace App\Http\Controllers;

use App\Models\SJ_Palet_D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SJ_Palet_DController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sj = DB::table('sj_palet_d')->get();

        return view('admin.sj_palet.index', compact('sj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $palet = DB::table('item_palet')->get();
        $sj_m = DB::table('sj_palet_m')->get();

        return view('admin.sj_palet.create', compact(
            'palet',
            'sj'
        ));
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
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
     * @return \Illuminate\Http\Response
     */
    public function show(SJ_Palet_D $sJ_Palet_D)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
     * @return \Illuminate\Http\Response
     */
    public function edit(SJ_Palet_D $sJ_Palet_D)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SJ_Palet_D $sJ_Palet_D)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
     * @return \Illuminate\Http\Response
     */
    public function destroy(SJ_Palet_D $sJ_Palet_D)
    {
        //
    }
}
