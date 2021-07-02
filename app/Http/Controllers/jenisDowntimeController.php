<?php

namespace App\Http\Controllers;

use App\Models\JenisDowntime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JenisDowntimeController extends Controller
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

        return view('admin.JenisDowntime.index', compact('jenisdowntime'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.JenisDowntime.create');
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
            'mesin' => 'required',
            'downtime' => 'required',
            'pic' => 'required',
            'allowedMinute' => 'nullable',
            'branch' => 'required',
            'createdBy' => 'required'
        ]);

        $data = JenisDowntime::create($request->all());

        // return response()->json(['success' => true, 'last_insert_id' => $data->id], 200);
        return redirect('admin/JenisDowntime');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisDowntime  $JenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $JenisDowntime = JenisDowntime::find($id);

        return view('admin.JenisDowntime.show', ['JenisDowntime' => $JenisDowntime]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisDowntime  $JenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $JenisDowntime = JenisDowntime::find($id);

        return view('admin.JenisDowntime.edit', ['JenisDowntime' => $JenisDowntime]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisDowntime  $JenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'mesin' => 'required',
            'downtime' => 'required',
            'pic' => 'required',
            'allowedMinute' => 'nullable',
            'branch' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $JenisDowntime = JenisDowntime::find($id);

        $JenisDowntime->mesin = $request->mesin;
        $JenisDowntime->downtime = $request->downtime;
        $JenisDowntime->pic = $request->pic;
        $JenisDowntime->allowedMinute = $request->allowedMinute;
        $JenisDowntime->branch = $request->branch;
        $JenisDowntime->lastUpdatedBy = Auth::user()->name;

        $JenisDowntime->save();

        return redirect('admin/JenisDowntime');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisDowntime  $JenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisDowntime $JenisDowntime)
    {
        //
    }
}

