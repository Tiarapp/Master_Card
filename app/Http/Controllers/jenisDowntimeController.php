<?php

namespace App\Http\Controllers;

use App\Models\jenisDowntime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $request->validate([
            'mesin' => 'required',
            'downtime' => 'required',
            'category' => 'required',
            'allowedMinute' => 'nullable',
            'branch' => 'required',
            'createdBy' => 'required'
        ]);

        $data = jenisDowntime::create($request->all());

        // return response()->json(['success' => true, 'last_insert_id' => $data->id], 200);
        return redirect('admin/JenisDowntime');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenisDowntime = jenisDowntime::find($id);

        return view('admin.jenisDowntime.show', ['jenisDowntime' => $jenisDowntime]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenisDowntime = jenisDowntime::find($id);

        return view('admin.jenisDowntime.edit', ['jenisDowntime' => $jenisDowntime]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\jenisDowntime  $jenisDowntime
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'mesin' => 'required',
            'downtime' => 'required',
            'category' => 'required',
            'allowedMinute' => 'nullable',
            'branch' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $jenisDowntime = jenisDowntime::find($id);

        $jenisDowntime->mesin = $request->mesin;
        $jenisDowntime->downtime = $request->downtime;
        $jenisDowntime->category = $request->category;
        $jenisDowntime->allowedMinute = $request->allowedMinute;
        $jenisDowntime->branch = $request->branch;
        $jenisDowntime->lastUpdatedBy = Auth::user()->name;

        $jenisDowntime->save();

        return redirect('admin/jenisDowntime');
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

