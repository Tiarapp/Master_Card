<?php

namespace App\Http\Controllers;

use App\Models\Wax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wax = DB::table('wax')
            ->where('deleted', '=', '0')
            ->get();
        
        return view('admin.wax.index', ['wax' => $wax]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = DB::table('satuan')->where('deleted', '=', '0')->get();
        $matauang = DB::table('mata_uang')->where('deleted', '=', '0')->get();

        return view('admin.wax.create', compact([
            'satuan',
            'matauang'
        ]));
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
            'luas' => 'required',
            'inOut' => 'required',
            'satuanLuas' => 'required',
            'gramWax' => 'required',
            'satuanGramWax' => 'required',
            'avgPrice' => 'required',
            'mataUang' => 'required',
            'createdBy' => 'required',
            'branch' => 'required'
        ]);

        Wax::create($request->all());

        return redirect('admin/wax');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wax  $wax
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wax = Wax::find($id);

        return view('admin.wax.show', ['wax' => $wax]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wax  $wax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wax = Wax::find($id);
        $satuan = DB::table('satuan')
            ->where('deleted', '=', '0')
            ->get();
        $matauang = DB::table('mata_uang')
            ->where('deleted', '=', '0')
            ->get();

        return view('admin.wax.edit', ['wax' => $wax], compact([
            'satuan',
            'matauang'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wax  $wax
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'luas' => 'required',
            'inOut' => 'required',
            'satuanLuas' => 'required',
            'gramWax' => 'required',
            'satuanGramWax' => 'required',
            'avgPrice' => 'required',
            'mataUang' => 'required',
            'branch' => 'required',
            'lastUpdatedBy' => 'required'
        ]);

        $wax = Wax::find($id);

        $wax->kode = $request->kode;
        $wax->nama = $request->nama;
        $wax->luas = $request->luas;
        $wax->inOut = $request->inOut;
        $wax->satuanLuas = $request->satuanLuas;
        $wax->gramWax = $request->gramWax;
        $wax->satuanGramWax = $request->satuanGramWax;
        $wax->avgPrice = $request->avgPrice;
        $wax->mataUang = $request->mataUang;
        $wax->branch = $request->branch;
        $wax->lastUpdatedBy = $request->lastUpdatedBy;

        $wax->save();

        return redirect('admin/wax');
    }

    public function updateDeleted($id)
    {
        $wax = Wax::find($id);

        $wax->deleted = 1;
        $wax->deletedAt = date('Y-m-d h:i:s');
        $wax->lastUpdatedBy = Auth::user()->name;
        $wax->deletedBy = Auth::user()->name;

        $wax->save();

        return redirect('/admin/wax');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wax  $wax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wax $wax)
    {
        //
    }
}
