<?php

namespace App\Http\Controllers;

use App\Models\SJ_Palet_D;
use App\Models\SJ_Palet_M;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SJ_Palet_DController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $sj = DB::table('sj_palet_m')->orderBy('noSuratJalan', 'DESC')->get();
        
        return view('admin.sj_palet.index', compact('sj'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $palet = DB::table('item_palet')->get();
        $customer = DB::connection('firebird')->table('TCustomer')->get();
        $url = Route::currentRouteName();
        
        return view('admin.sj_palet.create', compact(
            'palet',
            'url',
            'customer'
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

        $start = Carbon::createFromFormat('Y-m-d', $tanggal)
            ->firstOfMonth()
            ->format('Y-m-d');

        $end = Carbon::createFromFormat('Y-m-d', $tanggal)
        ->endOfMonth()
        ->format('Y-m-d');

        $fromDate = Carbon::now()->startOfMonth();
        $tillDate = Carbon::now()->endOfMonth();
        
        if (strpos($fromDate, $start) !== false ) {
            $result = SJ_Palet_M::whereBetween(DB::raw('date(tanggal)'), [$fromDate, $tillDate])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YY~', date('y'), $nobukti);
                $nobukti = str_replace('~MM~', date('m'), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        } else {
            $result = SJ_Palet_M::whereBetween(DB::raw('date(tanggal)'), [$start, $end])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YY~', date('y', strtotime($start)), $nobukti);
                $nobukti = str_replace('~MM~', date('m', strtotime($start)), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        }
        // $month = date_format($start, 'Y-m-d');
        
        $request->validate([
                'tanggal' => 'required',
                'noPolisi' => 'required',
                'namaCustomer' => 'required',
                'alamatCustomer' => 'required',
            ]);
            
        $sjpaletm = SJ_Palet_M::create([
                'noSuratJalan' => $nobukti,
                'tanggal' => $request->tanggal,
                'noPolisi' => $request->noPolisi,
                'noPoCustomer' => $request->noPoCustomer,
                'namaCustomer' => $request->namaCustomer,
                'alamatCustomer' => $request->alamatCustomer,
                'catatan' => $request->catatan,
                'createdBy' => $request->createdBy,
            ]);
            
        for ($i=1; $i < 6; $i++) { 
            if ($request->nama[$i] !== null) {
                SJ_Palet_D::create([
                    'sj_palet_m_id' => $sjpaletm->id,
                    'item_palet_id' => $request->idpalet[$i],
                    'qty' => $request->qty[$i],
                    'namaBarang' => $request->nama[$i],
                    'ukuran' => $request->ukuran[$i],
                    'noKontrak' => $request->noKontrak[$i],
                    'keterangan' => $request->keterangan[$i],
                    'createdBy' => $request->createdBy,
                    ]);
                }
            }
                
                return redirect('../admin/sj_palet');
                
            }
            
    /**
    * Display the specified resource.
    *
    * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
    * @return \Illuminate\Http\Response
    */
    public function show($sj_palet_m_id)
    {
        $sj_Palet_M = SJ_Palet_M::find($sj_palet_m_id);
        $sj_Palet_D = DB::table('sj_Palet_D')
        ->where('sj_palet_m_id', '=', $sj_palet_m_id)
        ->get();
        
        return view('admin.sj_palet.show', compact(
            'sj_Palet_M',
            'sj_Palet_D'
        ));
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
    * @return \Illuminate\Http\Response
    */
    public function edit(SJ_Palet_D $sJ_Palet_D)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, SJ_Palet_D $sJ_Palet_D)
    {
        //
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\SJ_Palet_D  $sJ_Palet_D
    * @return \Illuminate\Http\Response
    */
    public function destroy(SJ_Palet_D $sJ_Palet_D)
    {
        //
    }
    
    public function pdfprint($sj_palet_m_id){
        $sj_Palet_M = SJ_Palet_M::find($sj_palet_m_id);
        $sj_Palet_D = DB::table('sj_Palet_D')
        ->where('sj_palet_m_id', '=', $sj_palet_m_id)
        ->get();
        
        return view('admin.sj_palet.pdf', compact(
            'sj_Palet_M',
            'sj_Palet_D'
        ));
    }
}
        