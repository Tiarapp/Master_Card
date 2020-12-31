<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = DB::table('sales')
            ->where('deleted', '=', '0')
            ->get();

            return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sales.create');
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
            'nama' => 'required',
            'alias' => 'required',
            'hp' => 'required | numeric',
            'komisi' => 'required | numeric',
            'createdBy' => 'required',
            'branch' => 'required'
        ]);

        Sales::create($request->all());

        return redirect('/admin/sales');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sales::find($id);

        return view('admin.sales.show', ['sales' => $sales]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales = Sales::find($id);

        return view('admin.sales.edit', ['sales' => $sales]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alias' => 'required',
            'hp' => 'required|numeric',
            'komisi' => 'required|numeric',
            'lastUpdatedBy' => 'required',
            'branch' => 'required'
        ]);

        $sales = Sales::find($id);

        $sales->nama = $request->nama;
        $sales->alias = $request->alias;
        $sales->hp = $request->hp;
        $sales->komisi = $request->komisi;
        $sales->branch = $request->branch;
        $sales->lastUpdatedBy = $request->lastUpdatedBy;

        $sales->save();
            // dd($sales->save());
        return redirect('/admin/sales');
    }

    public function updateDeleted($id)
    {
        $sales = Sales::find($id);

        $sales->deleted = 1;
        $sales->deletedAt = date('Y-m-d h:i:s');
        $sales->lastUpdatedBy = Auth::user()->name;
        $sales->deletedBy = Auth::user()->name;

        $sales->save();

        return redirect('/admin/satuans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
