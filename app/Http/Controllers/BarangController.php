<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Tampilkan awal
     public function index()
    {

        $periode = date("m/Y");
        $barang = DB::connection('firebird2')->table('TPersediaan')
        ->leftJoin('TBarangConv', 'TPersediaan.KodeBrg', '=', 'TBarangConv.KodeBrg')
        ->select('TPersediaan.KodeBrg', 'TBarangConv.NamaBrg', 'TPersediaan.SaldoAkhirCrt as SaldoPcs', 'TPersediaan.SaldoAkhirKg as SaldoKg', 'TPersediaan.Periode', 'TBarangConv.BeratStandart', 'TBarangConv.Satuan', 'TBarangConv.IsiPerKarton', 'TBarangConv.WeightValue')
        ->where('TPersediaan.Periode', 'LIKE', "%".$periode."%")
        ->orderBy('TPersediaan.KodeBrg', 'asc')->get();

        // dd($barang);

        return view('admin.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Tampilkan Halaman Input
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
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // Tampilkan halaman Edit
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // Untuk Simpan yg sudah diedit    
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // Untuk Delete
    public function destroy(Barang $barang)
    {
        //
    }
}
