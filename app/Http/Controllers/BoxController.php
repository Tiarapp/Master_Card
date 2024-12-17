<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Tracking;
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
    // Tampilkan Halaman Awal
    public function index()
    {
        // Ambil data dari table box

        $box = DB::table('box')->get();

        $finance = DB::connection('sqlsrv')->table('COA')->get();

        dd($finance);

        // Tampilkan semua isi variable $box
        return view('admin.box.index', ['box' => $box]);
    }
    // End tampilkan Halaman Awal

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Tampilkan Halaman Input
    public function create()
    {
        // Ambil data dari table (flute,tipe_box,firebird(TBarangConv))
        $flute = DB::table('flute')->get();
        $tipebox = DB::table('tipe_box')->get();
        // $item = DB::connection('firebird2')->table('TBarangConv')->get();
        // End ambil data dari table (flute,tipe_box,firebird(TBarangConv))

        return view('admin.box.create', compact([
            'tipebox',
            'flute',
            // 'item'
            ]));
    }
    // End tampilkan Halaman Input

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = Route::currentRouteName();
        // Calculating Number Sequence
        // Ambil format Number Sequence
        $ns = DB::table('number_sequence')
        ->select('format')
        ->where('noBukti', '=', $url)->get();
        
        $nobukti = $ns[0]->format;
        // End ambil format Number Sequence
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

        $box = Box::create([
            'kode' => $nobukti,
            // 'kodeBarang' => $request->kodeBarang,
            'namaBarang' =>strtoupper($request->namaBarang),
            'tipebox' => $request->tipebox,
            'flute' => $request->flute,
            'tipeCreasCorr' => $request->tipeCreasCorr,
            'sizeCreasConv' => $request->sizeCreasConv,
            'sizeCreasCorr' => $request->sizeCreasCorr,
            'kuping' => $request->kuping,
            'kuping2' =>$request->kuping2,
            'panjangSheetBox' => $request->panjangsheet,
            'panjangLebarBox' => $request->lebarsheet,
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

        Tracking::create([
            'user' => Auth::user()->name,
            'event' => "Tambah Box ".$nobukti
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
        $flute = DB::table('flute')->get();
        $box = Box::find($id);

        return view('admin.box.edit', compact('tipebox', 'box', 'flute'));
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
        
        // dd($request->all()); 

        $box = Box::find($id);

        // $box->kode = $request->kode;
        $box->namaBarang = $request->namaBarang;
        $box->tipebox = $request->tipebox;
        $box->flute = $request->flute;
        $box->tipeCreasCorr = $request->tipeCreasCorr;
        $box->panjangDalamBox = $request->panjangDalamBox;
        $box->lebarDalamBox = $request->lebarDalamBox;
        $box->tinggiDalamBox = $request->tinggiDalamBox;
        $box->sizeCreasCorr = $request->sizeCreasCorr;
        $box->sizeCreasConv = $request->sizeCreasConv;
        $box->kuping = $request->kuping;
        $box->kuping2 = $request->kuping2;
        $box->panjangCrease = $request->panjangCrease;
        $box->lebarCrease1 = $request->lebarCrease1;
        $box->lebarCrease2 = $request->lebarCrease2;
        $box->flapCrease = $request->flapCrease;
        $box->tinggiCrease = $request->tinggiCrease;
        $box->lastUpdatedBy = $request->createdBy;

        $box->save();

        Tracking::create([
            'user' => Auth::user()->name,
            'event' => "Ubah Box ".$box->kode
        ]);

        return redirect('admin/box');
    }

    // Update field Deleted
    public function updateDeleted($id)
    {
        $box = Box::find($id);                  //cari id yang akan dihapus

        $box->deleted = 1;                      //isi field deleted dengan 1
        $box->deletedAt = date('Y-m-d h:i:s');  //update tanggal dan jam hapus
        $box->deletedBy = Auth::user()->name;   //update user yang hapus

        $box->save();                           //simpan

        return redirect('/admin/box');
    }
    // End update field deleted

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
