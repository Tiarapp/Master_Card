<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Kontrak_DController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kontrak_m = DB::table('kontrak_m')
            ->get();

        return view('admin.kontrak.index', compact('kontrak_m'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust = DB::connection('firebird')->table('TCustomer')->get();
        $mc = DB::table('mc')->where('tipeMC', '=', 'BOX')->get();
        $mcpel = DB::table('mc')->where('tipeMC', '!=', 'BOX')->get();
        $top = DB::table('top')->get();
        
        return view('admin.kontrak.create', compact(
            'mc','mcpel', 'top'
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function show(Kontrak_D $kontrak_D)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function edit(Kontrak_D $kontrak_D)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kontrak_D $kontrak_D)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kontrak_D $kontrak_D)
    {
        //
    }
}
