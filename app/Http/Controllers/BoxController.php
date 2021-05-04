<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $box = DB::table('box')
            ->get();

        return view('admin.box.index', ['box' => $box]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $flute = DB::table('flute')->get();
        $tipebox = DB::table('tipe_box')->get();
        $item = DB::connection('firebird2')->table('TBarangConv')->get();

        return view('admin.box.create', compact([
            'tipebox',
            'flute',
            'item'
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
        $url = Route::currentRouteName();
        $ns = DB::table('number_sequence')
        ->select('format')
        ->where('noBukti', '=', $url)->get();
        
        $nobukti = $ns[0]->format;
        $tanggal = date(now());

        // dd($nobukti, $tanggal);

        $start = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal)
            ->firstOfMonth()
            ->format('Y-m-d');

        $end = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal)
        ->endOfMonth()
        ->format('Y-m-d');

        $fromDate = Carbon::now()->startOfMonth();
        $tillDate = Carbon::now()->endOfMonth();

        if (strpos($fromDate, $start) !== false ) {
            $result = Box::whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YY~', date('Y'), $nobukti);
                $nobukti = str_replace('~MM~', date('m'), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        } else {
            $result = Box::whereBetween(DB::raw('date(createdAt)'), [$start, $end])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YY~', date('Y', strtotime($start)), $nobukti);
                $nobukti = str_replace('~MM~', date('m', strtotime($start)), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        }

        // dd($nobukti);

        // $request->validate([
        //     'kode' => 'required',
        //     'kodeBarang' => 'nullable',
        //     'namaBarang' => 'required',
        //     'tipebox' => 'required',
        //     'flute' => 'required',
        //     'tipeCreasCorr' => 'required',
        //     // 'lebarSheetBox' => 'nullable',
        //     // 'panjangSheetBox' => 'nullable',
        //     // 'tinggiSheetBox' => 'nullable',
        //     // 'luasSheetBox' => 'nullable',
        //     'panjangDalamBox' => 'nullable',
        //     'lebarDalamBox' => 'nullable',
        //     'kuping' => 'nullable',
        //     'panjangCrease' => 'nullable',
        //     'lebarCrease1' => 'nullable',
        //     'lebarCrease2' => 'nullable',
        //     'flapCrease' => 'nullable',
        //     'tinggiCrease' => 'nullable',
        //     'tinggiDalamBox' => 'nullable',
        //     'sizeCreasCorr' => 'nullable',
        //     'sizeCreasConv' => 'nullable',
        //     'createdBy' => 'required'
        // ]);

        Box::create([
            'kode' => $nobukti,
            'kodeBarang' => $request->kodeBarang,
            'namaBarang' => $request->namaBarang,
            'tipebox' => $request->tipebox,
            'flute' => $request->flute,
            'tipeCreasCorr' => $request->tipeCreasCorr,
            'sizeCreasConv' => $request->sizeCreasConv,
            'sizeCreasCorr' => $request->sizeCreasCorr,
            'kuping' => $request->kuping,
            'panjangDalamBox' => $request->panjangDalamBox,
            'lebarDalamBox' => $request->lebarDalamBox,
            'tinggiDalamBox' => $request->tinggiDalamBox,
            'panjangCrease' => $request->panjangCrease,
            'lebarCrease1' => $request->lebarCrease1,
            'lebarCrease2' => $request->lebarCrease2,
            'flapCrease' => $request->flapCrease,
            'tinggiCrease' => $request->tinggiCrease,
            'createdBy' => $request->createdBy
            ]);

        return redirect('admin/box');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $box = Box::find($id);

        return view('admin.box.show', ['box' => $box]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipebox = DB::table('tipe_box')->get();
        $box = Box::find($id);

        return view('admin.box.show', ['box' => $box], compact('tipebox'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'boxtipe_id' => 'required',
            'tipeCreasCorr' => 'required',
            'lebarSheetCorr' => 'required|numeric',
            'panjangSheetBox' => 'required|numeric',
            'tinggiSheetBox' => 'required|numeric',
            'satuanSizeSheetBox' => 'required',
            'luasSheetBox' => 'required|numeric',
            'satuanLuasSheetBox' => 'required',
            'panjangDalamBox' => 'required',
            'lebarDalamBox' => 'required',
            'tinggiDalamBox' => 'required',
            'satuanSizeDalamBox' => 'required',
            'sizeCreasCorr' => 'required',
            'sizeCreasConv' => 'required',
            'satuanCreas' => 'required',
            'lastUpdatedBy' => 'required'
        ]);

        $box = Box::find($id);

        $box->kode = $request->kode;
        $box->nama = $request->nama;
        $box->tipebox_id = $request->tipebox_id;
        $box->tipeCreasCorr = $request->tipeCreasCorr;
        $box->lebarSheetCorr = $request->lebarSheetCorr;
        $box->panjangSheetBox = $request->panjangSheetBox;
        $box->tinggiSheetBox = $request->tinggiSheetBox;
        $box->satuanSizeSheetBox = $request->satuanSizeSheetBox;
        $box->luasSheetBox = $request->luasSheetBox;
        $box->satuanLuasSheetBox = $request->satuanLuasSheetBox;
        $box->gramSheetBox = $request->gramSheetBox;
        $box->panjangDalamBox = $request->panjangDalamBox;
        $box->lebarDalamBox = $request->lebarDalamBox;
        $box->tinggiDalamBox = $request->tinggiDalamBox;
        $box->satuanSizeDalamBox = $request->satuanSizeDalamBox;
        $box->sizeCreasCorr = $request->sizeCreasCorr;
        $box->sizeCreasConv = $request->sizeCreasConv;
        $box->satuanCreas = $request->satuanCreas;
        $box->lastUpdatedBy = $request->lastUpdatedBy;

        $box->save();

        return redirect('admin/box');
    }

    public function updateDeleted($id)
    {
        $box = Box::find($id);

        $box->deleted = 1;
        $box->deletedAt = date('Y-m-d h:i:s');
        $box->deletedBy = Auth::user()->name;

        $box->save();

        return redirect('/admin/box');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        //
    }
}
