<?php

namespace App\Http\Controllers;

use App\Models\Substance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $substance = DB::table('substance')
            ->leftJoin('jenis_gram as linerAtas', 'jenisGramLinerAtas_id', '=', 'linerAtas.id')
            ->leftJoin('jenis_gram as bf', 'jenisGramBf_id', '=', 'bf.id')
            ->leftJoin('jenis_gram as linerTengah', 'jenisGramLinerTengah_id', '=', 'linerTengah.id')
            ->leftJoin('jenis_gram as cf', 'jenisGramCf_id', '=', 'cf.id')
            ->leftJoin('jenis_gram as linerBawah', 'jenisGramLinerBawah_id', '=', 'linerBawah.id')
            ->select('substance.*', 'linerAtas.nama AS linerAtas', 'bf.nama AS bf', 'linerTengah.nama AS linerTengah', 'cf.nama AS cf', 'linerBawah.nama AS linerBawah')
            ->get();

        return view('admin.substance.index', ['substance' => $substance]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisgram1 = DB::table('jenis_gram')->where('jenisKertas', '!=', 'MF')->get();
        $jenisgram2 = DB::table('jenis_gram')->where('jenisKertas', '!=', 'ML')->get();
        $flute = DB::table('flute')->get();

        return view('admin.substance.create', compact(
            'jenisgram1',
            'jenisgram2',
            'flute'
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

        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'jenisGramLinerAtas_id' => 'required',
            'jenisGramBf_id' => 'nullable',
            'jenisGramLinerTengah_id' => 'nullable',
            'jenisGramCf_id' => 'nullable',
            'jenisGramLinerBawah_id' => 'required',
            'createdBy' => 'required'
        ]);

        Substance::create($request->all());

        return redirect('admin/substance');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function show(Substance $substance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function edit(Substance $substance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Substance $substance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Substance  $substance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Substance $substance)
    {
        //
    }
}
