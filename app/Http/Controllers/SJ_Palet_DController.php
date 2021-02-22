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
        $sj = DB::table('sj_palet_m')->get();
        
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
        $tanggal = $request->tanggal;


        
        $ns = DB::table('number_sequence')
        ->select('format')
        ->where('noBukti', '=', $url)->get();
        
        // var_dump($ns[0]->format);
        
        $nobukti = $ns[0]->format;
        
        if ($nobukti === $nobukti) {
            $nobukti = str_replace('~YY~', date('y'), $nobukti);
            $nobukti = str_replace('~MM~', date('m'), $nobukti);
            
            $fromDate = Carbon::now()->startOfMonth();
            $tillDate = Carbon::now()->endOfMonth();
            
            $result = SJ_Palet_M::whereBetween(DB::raw('date(tanggal)'), [$fromDate, $tillDate])->get();
            $count = count($result)+1;
            
            $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);

            var_dump($fromDate);
        }
        
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
                            
                            return redirect('/admin/sj_palet');
                            
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
                    