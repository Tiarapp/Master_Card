<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SatuansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('satuan.index');
        // $satuan = DB::table('satuan')->get()
        // ->where('deleted', '0');

        // return view('admin.satuans.index', ['data' => $satuan]);

        $satuans = DB::table('satuan')->simplePaginate(25);

        return view('admin.satuans.index', compact('satuans'));

        // dd(Auth::user()->nama);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.satuans.create');
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
            'branch' => 'required',
            'createdBy' => 'required'
        ]);

        Satuan::create($request->all());
        return redirect()->route('satuans.index')
            ->with('success', 'Satuan Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan)
    {
        return view('admin.satuans.show', compact('satuan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        return view('admin.satuans.edit', compact('satuan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'branch' => 'required',
            'lastUpdatedBy' => 'required'
        ]);

        $satuan->update($request->all());

       
        return redirect()->route('satuans.index')
                ->with('success', 'Update Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return redirect()->route('admin.satuans.index')
                ->with('success', 'Delete success');
    }
}
