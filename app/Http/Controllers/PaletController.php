<?php

namespace App\Http\Controllers;

use App\Models\Keyfield;
use App\Models\Palet;
use App\Models\SJ;
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

    public function sync_sj()
    {
        DB::connection('firebird2')->beginTransaction();
        $periode = '12/2024';

        $barang = DB::connection('firebird2')->table('TSuratJalan')->where('Periode', '=', $periode)->get();
        
        $key = DB::connection('firebird2')->table('TKeyfield')->where('Nama', 'LIKE', 'CA-22412'.'%')->update([
            'NoUrut' => count($barang)
        ]);
        
        DB::connection('firebird2')->commit();

        return redirect('/admin/sj_palet');
    }

    public function sync_fa()
    {
        DB::connection('firebird2')->beginTransaction();
        $periode = '12/2024';

        $faktur = DB::connection('firebird2')->table('TFakturConv')->where('Periode', '=', $periode)->get();
        
        $key = DB::connection('firebird2')->table('TKeyfield')->where('Nama', 'LIKE', 'FA/XII/24'.'%')->update([
            'NoUrut' => count($faktur)
        ]);
        
        DB::connection('firebird2')->commit();

        return redirect('/admin/data/alamat');
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
            'kodePalet' => 'required',
            'nama' => 'required',
            'kodePalet' => 'required',
            'ukuran' => 'required',
            'keterangan' => 'nullable'
        ]);

        Palet::create($request->all());

        return redirect('admin/palet');
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

    // public function getPalet(Request $request)
    // {
    //     $request = $request->request;

    //     var_dump($request);
    // }
}
