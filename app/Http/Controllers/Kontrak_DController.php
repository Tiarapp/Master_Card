<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class Kontrak_DController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kontrak_m = DB::table('kontrak_m') 
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->select('kontrak_m.*', 'mc.kode as nomc')
            ->get();

        return view('admin.kontrak.index', compact('kontrak_m'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust = DB::connection('firebird')->table('TCustomer')->get();
        $mc = DB::table('mc')->where('tipeMC', '=', 'BOX')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            ->get();
        $mcpel = DB::table('mc')->where('tipeMC', '!=', 'BOX')
        ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
        ->select('mc.*', 'substance.kode as substancePel')
        ->get();
        $top = DB::table('top')->get();
        $sales = DB::table('sales_m')->get();
        
        return view('admin.kontrak.create', compact(
            'mc','mcpel', 'top', 'cust', 'sales'
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
        $url = Route::currentRouteName();
        $ns = DB::table('number_sequence')
        ->select('format')
        ->where('noBukti', '=', $url)->get();
        
        $nobukti = $ns[0]->format;
        $tanggal = $request->tanggal;

        // dd($nobukti, $tanggal);

        $start = Carbon::createFromFormat('Y-m-d', $tanggal)
            ->firstOfMonth()
            ->format('Y-m-d');

        $end = Carbon::createFromFormat('Y-m-d', $tanggal)
        ->endOfMonth()
        ->format('Y-m-d');

        $fromDate = Carbon::now()->startOfMonth();
        $tillDate = Carbon::now()->endOfMonth();

        if (strpos($fromDate, $start) !== false ) {
            $result = Kontrak_M::whereBetween(DB::raw('date(tglKontrak)'), [$fromDate, $tillDate])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YYYY~', date('Y'), $nobukti);
                $nobukti = str_replace('~MM~', date('m'), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        } else {
            $result = Kontrak_M::whereBetween(DB::raw('date(tglKontrak)'), [$start, $end])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YYYY~', date('Y', strtotime($start)), $nobukti);
                $nobukti = str_replace('~MM~', date('m', strtotime($start)), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        }


        // // dd($nobukti);

        $kontrakm = Kontrak_M::create([
            'kode' => $nobukti,
            'mc_id' => $request->mcid,
            'tglKontrak' => $request->tanggal,
            'top' => $request->top,
            'customer_name' => $request->namaCust,
            'alamatKirim' => $request->alamatKirim,
            'caraKirim' => $request->caraKirim,
            'pcsKontrak' => $request->jmlOrder,
            'pcsSisaKontrak' => $request->jmlOrder,
            'kgKontrak' => $request->beratTotal,
            'kgSisaKontrak' => $request->beratTotal,
            'harga' => $request->hargaSatuan,
            'pctToleransiLebihKontrak' => $request->toleransiLebihPersen,
            'pctToleransiKurangKontrak' => $request->toleransiKurangPersen,
            'pcsKurangToleransiKontrak' => $request->toleransiKurangPcs,
            'pcsLebihToleransiKontrak' => $request->toleransiLebihPcs,
            'kgKurangToleransiKontrak' => $request->toleransiKurangKg,
            'kgLebihToleransiKontrak' => $request->toleransiLebihKg,
            'amountBeforeTax' => $request->hargaBlmTax,
            'tax' => $request->tax,
            'amountTotal' => $request->totalHarga,
            'sales' => $request->sales,
            'status' => 'Berjalan',
            'createdBy' => $request->createdBy
        ]);

        // dd($kontrakm);

        for ($i=1; $i < 6; $i++) { 
            if ($request->idmcpel[$i] !== null) {
                $kontrakd = Kontrak_D::create([
                    'kontrak_m_id' => $kontrakm->id,
                    'mc_id' => $request->idmcpel[$i],
                    'pcsPelengkapKontrak' => $request->qtyPcs[$i],
                    'pcsPelengkapSisaKontrak' => $request->qtyPcs[$i],
                    'kgPelengkapKontrak' => $request->qtyKg[$i],
                    'pctToleransiPelengkapKontrak' => $request->toleransi[$i],
                    'pcsToleransiPelengkapKontrak' => $request->pcsToleransi[$i],
                    'kgToleransiPelengkapKontrak' => $request->kgToleransi[$i],
                    'createdBy' => $request->createdBy,
                    ]);

                // dd($kontrakd);
                }
            }

        return redirect('admin/kontrak');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function show(Kontrak_D $kontrak_D)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cust = DB::connection('firebird')->table('TCustomer')->get();
        $mc = DB::table('mc')->where('tipeMC', '=', 'BOX')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            ->get();
        $mcpel = DB::table('mc')->where('tipeMC', '!=', 'BOX')
        ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
        ->select('mc.*', 'substance.kode as substancePel')
        ->get();
        $top = DB::table('top')->get();
        $sales = DB::table('sales_m')->get();

        $kontrak_D = DB::table('kontrak_d')
            ->where('kontrak_m_id', '=', $id)
            ->get();

        $kontrak_M = Kontrak_M::find($id);

        $count = count($kontrak_D);


        // dd($kontrak_M);
        return view('admin.kontrak.edit', compact(
            'cust',
            'mc',
            'mcpel',
            'top',
            'sales',
            'count'
        ), ['kontrak_M' => $kontrak_M]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kontrak_D $kontrak_D)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kontrak_D $kontrak_D)
    {
        //
    }
}
