<?php

namespace App\Http\Controllers;

use App\Models\jenisDowntime;
use Illuminate\Http\Request;

class jenisDowntimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


$table->id('id');
$table->foreignId('mesin_id')->index();
$table->string('downtime')->index();
$table->integer('allowedMinute')->index();
// TRACKING
$table->string('createdBy');                    //Auto ambil dari login
$table->string('lastUpdatedBy')->nullable();    //Auto ambil dari login
$table->dateTime('deletedAt')->nullable();      //Auto ambil dari today()
$table->string('deletedBy')->nullable();        //Auto ambil dari login
$table->integer('printedKe')->nullable();       //Auto ambil dari login
$table->dateTime('printedAt')->nullable();      //Auto ambil dari login
$table->string('branch')->default('Lamongan')->index();              //Auto ambil dari login awal
$table->timestamps();
