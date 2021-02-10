<?php

namespace App\Http\Controllers;

use App\Models\Palet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $palet = DB::table('item_palet')->get();

        return view('admin.palet.index', compact('palet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.palet.create');
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
     * @param  \App\Models\Palet  $palet
     * @return \Illuminate\Http\Response
     */
    public function show(Palet $palet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Palet  $palet
     * @return \Illuminate\Http\Response
     */
    public function edit(Palet $palet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Palet  $palet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Palet $palet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Palet  $palet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Palet $palet)
    {
        //
    }
}
