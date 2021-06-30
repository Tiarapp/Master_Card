<?php

namespace App\Http\Controllers;

use App\Models\jenisDowntime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class jenisDowntimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisdowntime = DB::table('jenis_downtime')
            ->get();

        return view('admin.jenisdowntime.index', compact('jenisdowntime'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jenisdowntime.create');
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
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function show(jenisDowntime $jenisDowntime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function edit(jenisDowntime $jenisDowntime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, jenisDowntime $jenisDowntime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function destroy(jenisDowntime $jenisDowntime)
    {
        //
    }
}

