<?php

namespace App\Http\Controllers;

use App\Models\Joint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class JointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $joint = DB::table('joint')->get();

        // dd($joint);
        return view('admin.joint.index', ['joint' => $joint]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/joint/create');
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
            'createdBy' => 'required',
            'branch' => 'required'
        ]);

        Joint::create($request->all());

        return redirect('admin/joint');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Joint  $joint
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $joint = Joint::find($id);

        return view('admin.joint.show', ['joint' => $joint ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Joint  $joint
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $joint = Joint::find($id);

        return view('admin.joint.edit', ['joint' => $joint]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Joint  $joint
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'branch' => 'required',
            'lastUpdatedBy' => 'required',
        ]);

        $joint = Joint::find($id);

        $joint->kode = $request->kode;
        $joint->nama = $request->nama;
        $joint->branch = $request->branch;
        $joint->lastUpdatedBy = $request->lastUpdatedBy;

        $joint->save();

        return redirect('admin/joint');
    }

    public function updateDeleted($id)
    {
        $joint = Joint::find($id);

        $joint->deleted = 1;
        $joint->deletedAt = date('Y-m-d h:i:s');
        $joint->lastUpdatedBy = Auth::user()->name;
        $joint->deletedBy = Auth::user()->name;

        $joint->save();

        return redirect('/admin/joint');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Joint  $joint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Joint $joint)
    {
        //
    }
}
