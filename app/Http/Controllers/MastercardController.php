<?php

namespace App\Http\Controllers;

use App\Models\Mastercard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MastercardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexb1()
    {
        $mc = DB::table('mc')
        ->where('tipeBox', '!=', 'DC')
        ->get();

        return view('admin.mastercard.index', compact('mc'));
    }

    public function indexdc()
    {
        $mc = DB::table('mc')
        ->where('tipeBox', '=', 'DC')
        ->orderBy('id','desc')
        ->get();

        // dd($mc);

        return view('admin.mastercard.index', compact('mc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $item = DB::connection('firebird2')->table('TBarangConv')->get();
        $substance = DB::table('substance')
            ->leftJoin('jenis_gram as linerAtas', 'jenisGramLinerAtas_id', '=', 'linerAtas.id')
            ->leftJoin('jenis_gram as bf', 'jenisGramFlute1_id', '=', 'bf.id')
            ->leftJoin('jenis_gram as linerTengah', 'jenisGramLinerTengah_id', '=', 'linerTengah.id')
            ->leftJoin('jenis_gram as cf', 'jenisGramFlute2_id', '=', 'cf.id')
            ->leftJoin('jenis_gram as linerBawah', 'jenisGramLinerBawah_id', '=', 'linerBawah.id')
            ->select('substance.*', 'linerAtas.gramKertas AS linerAtas', 'bf.gramKertas AS bf', 'linerTengah.gramKertas AS linerTengah', 'cf.gramKertas AS cf', 'linerBawah.gramKertas AS linerBawah')
            ->get();
        $box = DB::table('box')->get();
        $colorcombine = DB::table('color_combine')->get();
        $joint = DB::table('joint')->get();
        $koli = DB::table('koli')->get();
        
        return view('admin.mastercard.create', compact([
            // 'item',
            'substance',
            'box',
            'colorcombine',
            'joint',
            'koli'
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
        $messages = [
            'koli.required' => 'Mohon isi Kolom Koli'
        ];

        $this->validate($request, [
            'kode' => 'required',
            'revisi' => 'nullable',
            'namaBarang' => 'required',
            'kodeBarang' => 'nullable',
            'poCsustomer' => 'nullable',
            'tipebox' => 'required',
            'CreasCorrP' => 'nullable',
            'CreasCorrL' => 'nullable',
            'joint' => 'nullable',
            'flute' => 'required',
            'luasSheet' => 'required',
            'lebarSheetBox' => 'required',
            'panjangSheetBox' => 'required',
            'luasSheetBox' => 'required',
            'mesin' => 'nullable',
            'outConv' => 'nullable',
            'substanceKontrak_id' => 'required',
            'substanceProduksi_id' => 'required',
            'koli' => 'required',
            'bungkus' => 'required',
            'wax' => 'nullable',
            // 'tipeMc' => 'required',
            'box_id' => 'required',
            'gramSheetBoxKontrak' => 'nullable',
            'gramSheetBoxKontrak2' => 'nullable',
            'gramSheetBoxProduksi' => 'nullable',
            'gramSheetBoxProduksi2' => 'nullable',
            'gramSheetCorrKontrak' => 'nullable',
            'gramSheetCorrKontrak2' => 'nullable',
            'gramSheetCorrProduksi' => 'nullable',
            'gramSheetCorrProduksi2' => 'nullable',
            'colorCombine_id' => 'required',
            'keterangan' => 'nullable',
            'gambar'    => 'nullable|file|mimes:jpeg,png,jpg|max: 1048',
            'createdBy' => 'required',
        ], $messages);

        // dd($request->file('gambar'));
        $file = $request->file('gambar');
        if ($file != null) {
            $nama_file = time()."_".$file->getClientOriginalName();

            $tujuan_upload = 'upload';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = '';
        }


        
        // if ($request->tipebox == 'DC') {
        //     $lock = 1;        
        // } else {
        //     $lock = 0;
        // }

        Mastercard::create([
            'kode' => $request->kode,
            'namaBarang' => $request->namaBarang,
            'kodeBarang' => $request->kodeBarang,
            'poCustomer' => $request->poCustomer,
            'tipebox' => $request->tipebox,
            'CreasCorrP' => $request->creasConv,
            'CreasCorrL' => $request->creasCorr,
            'joint' => $request->joint,
            'flute' => $request->flute,
            'lebarSheet' => $request->lebarSheet,
            'panjangSheet' => $request->panjangSheet,
            'tinggiSheet' => $request->tinggiSheet,
            'luasSheet' => $request->luasSheet,
            'panjangSheetBox' => $request->panjangSheetBox,
            'lebarSheetBox' => $request->lebarSheetBox,
            'luasSheetBox' => $request->luasSheetBox,
            'substanceKontrak_id' => $request->substanceKontrak_id,
            'substanceProduksi_id' => $request->substanceProduksi_id,
            'tipeMc' => $request->tipeMc,
            'mesin' => $request->mesin,
            'outConv' => $request->outConv,
            'koli' => $request->koli,
            'bungkus' => $request->bungkus,
            'wax' => $request->wax,
            'lock' => 0,
            'box_id' => $request->box_id,
            'gramSheetBoxKontrak' => $request->gramSheetBoxKontrak,
            'gramSheetBoxKontrak2' => $request->gramSheetBoxKontrak2,
            'gramSheetCorrKontrak' => $request->gramSheetCorrKontrak,
            'gramSheetCorrKontrak2' => $request->gramSheetCorrKontrak2,
            'gramSheetBoxProduksi' => $request->gramSheetBoxProduksi,
            'gramSheetBoxProduksi2' => $request->gramSheetBoxProduksi2,
            'gramSheetCorrProduksi' => $request->gramSheetCorrProduksi,
            'gramSheetCorrProduksi2' => $request->gramSheetCorrProduksi2,
            'colorCombine_id' => $request->colorCombine_id,
            'keterangan' => $request->keterangan,
            'gambar' => $nama_file,
            'createdBy' => $request->createdBy
        ]);

        return redirect('admin/mastercard/b1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mastercard  $mastercard
     * @return \Illuminate\Http\Response
     */
    public function show(Mastercard $mastercard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mastercard  $mastercard
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = DB::connection('firebird2')->table('TBarangConv')->get();
        $substance = DB::table('substance')
            ->leftJoin('jenis_gram as linerAtas', 'jenisGramLinerAtas_id', '=', 'linerAtas.id')
            ->leftJoin('jenis_gram as bf', 'jenisGramFlute1_id', '=', 'bf.id')
            ->leftJoin('jenis_gram as linerTengah', 'jenisGramLinerTengah_id', '=', 'linerTengah.id')
            ->leftJoin('jenis_gram as cf', 'jenisGramFlute2_id', '=', 'cf.id')
            ->leftJoin('jenis_gram as linerBawah', 'jenisGramLinerBawah_id', '=', 'linerBawah.id')
            ->select('substance.*', 'linerAtas.gramKertas AS linerAtas', 'bf.gramKertas AS bf', 'linerTengah.gramKertas AS linerTengah', 'cf.gramKertas AS cf', 'linerBawah.gramKertas AS linerBawah')
            ->get();
        $box = DB::table('box')->get();
        $colorcombine = DB::table('color_combine')->get();
        $joint = DB::table('joint')->get();
        $koli = DB::table('koli')->get();

        $mc = DB::table('mc')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->leftJoin('substance as subskontrak', 'substanceKontrak_id', '=', 'subskontrak.id')
            ->leftJoin('substance as subsproduksi', 'substanceProduksi_id', '=', 'subsproduksi.id')
            ->leftJoin('color_combine', 'colorcombine_id', '=', 'color_combine.id')
            ->where('mc.id', '=', $id)
            ->select('mc.*','color_combine.id as ccid','color_combine.nama as ccnama','subskontrak.namaMc as subsKontrak','subsproduksi.namaMc as subsProduksi', 'box.panjangDalamBox as panjangDalam','box.lebarDalamBox as lebarDalam','box.tinggiDalamBox as tinggiDalam', 'box.id as box_id' )
            ->first();

        $kodemc = DB::table('mc')
            ->where('kode', '=', $mc->kode)
            ->get();

        $revisi = count($kodemc);
        
        return view('admin.mastercard.edit', compact([
            'item',
            'substance',
            'box',
            'colorcombine',
            'joint',
            'koli',
            'mc',
            'revisi'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mastercard  $mastercard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $kode = DB::table('mc')
            ->where('kode', '=', $request->kode)
            ->get();
        
        $rev = "R".count($kode);

        // dd($rev);

        $messages = [
            'koli.required' => 'Mohon isi Kolom Koli'
        ];

        $this->validate($request, [
            'kode' => 'required',
            'revisi' => 'nullable',
            'namaBarang' => 'required',
            'kodeBarang' => 'nullable',
            'poCsustomer' => 'nullable',
            'tipebox' => 'required',
            'CreasCorrP' => 'nullable',
            'CreasCorrL' => 'nullable',
            'joint' => 'nullable',
            'flute' => 'required',
            'lebarSheet' => 'required',
            'panjangSheet' => 'required',
            'luasSheet' => 'required',
            'lebarSheetBox' => 'required',
            'panjangSheetBox' => 'required',
            'luasSheetBox' => 'required',
            'mesin' => 'nullable',
            // 'outConv' => 'required',
            'substanceKontrak_id' => 'required',
            'substanceProduksi_id' => 'required',
            'koli' => 'required',
            'bungkus' => 'required',
            'wax' => 'nullable',
            'tipeMc' => 'required',
            'box_id' => 'required',
            'gramSheetBoxKontrak' => 'nullable',
            'gramSheetBoxKontrak2' => 'nullable',
            'gramSheetBoxProduksi' => 'nullable',
            'gramSheetBoxProduksi2' => 'nullable',
            'gramSheetCorrKontrak' => 'nullable',
            'gramSheetCorrKontrak2' => 'nullable',
            'gramSheetCorrProduksi' => 'nullable',
            'gramSheetCorrProduksi2' => 'nullable',
            'colorCombine_id' => 'required',
            'keterangan' => 'nullable',
            // 'gambar'    => 'required|file|mimes:jpeg,png,jpg|max: 1048',
            'createdBy' => 'required',
        ], $messages);

        $file = $request->file('gambar');
        if ($file != null) {
            $nama_file = time()."_".$file->getClientOriginalName();

            $tujuan_upload = 'upload';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = '';
        }
        // $file = $request->file('gambar');
        // $nama_file = time()."_".$file->getClientOriginalName();

        // $tujuan_upload = 'upload';
        // $file->move($tujuan_upload, $nama_file);

        Mastercard::create([
            'kode' => $request->kode,
            'revisi' => $rev,
            'namaBarang' => $request->namaBarang,
            'kodeBarang' => $request->kodeBarang,
            'poCustomer' => $request->poCustomer,
            'tipebox' => $request->tipebox,
            'CreasCorrP' => $request->creasCorr,
            'CreasCorrL' => $request->creasConv,
            'joint' => $request->joint,
            'flute' => $request->flute,
            'lebarSheet' => $request->lebarSheet,
            'panjangSheet' => $request->panjangSheet,
            'tinggiSheet' => $request->tinggiSheet,
            'luasSheet' => $request->luasSheet,
            'panjangSheetBox' => $request->panjangSheetBox,
            'lebarSheetBox' => $request->lebarSheetBox,
            'luasSheetBox' => $request->luasSheetBox,
            'substanceKontrak_id' => $request->substanceKontrak_id,
            'substanceProduksi_id' => $request->substanceProduksi_id,
            'tipeMc' => $request->tipeMc,
            'mesin' => $request->mesin,
            'outConv' => $request->outConv,
            'koli' => $request->koli,
            'bungkus' => $request->bungkus,
            'wax' => $request->wax,
            'box_id' => $request->box_id,
            'gramSheetBoxKontrak' => $request->gramSheetBoxKontrak,
            'gramSheetBoxKontrak2' => $request->gramSheetBoxKontrak2,
            'gramSheetCorrKontrak' => $request->gramSheetCorrKontrak,
            'gramSheetCorrKontrak2' => $request->gramSheetCorrKontrak2,
            'gramSheetBoxProduksi' => $request->gramSheetBoxProduksi,
            'gramSheetBoxProduksi2' => $request->gramSheetBoxProduksi2,
            'gramSheetCorrProduksi' => $request->gramSheetCorrProduksi,
            'gramSheetCorrProduksi2' => $request->gramSheetCorrProduksi2,
            'colorCombine_id' => $request->colorCombine_id,
            'keterangan' => $request->keterangan,
            'gambar' => $nama_file,
            'createdBy' => $request->createdBy
        ]);

        return redirect('admin/mastercard/b1');
    }

    public function revisi($id)
    {
        $item = DB::connection('firebird2')->table('TBarangConv')->get();
        $substance = DB::table('substance')
            ->leftJoin('jenis_gram as linerAtas', 'jenisGramLinerAtas_id', '=', 'linerAtas.id')
            ->leftJoin('jenis_gram as bf', 'jenisGramFlute1_id', '=', 'bf.id')
            ->leftJoin('jenis_gram as linerTengah', 'jenisGramLinerTengah_id', '=', 'linerTengah.id')
            ->leftJoin('jenis_gram as cf', 'jenisGramFlute2_id', '=', 'cf.id')
            ->leftJoin('jenis_gram as linerBawah', 'jenisGramLinerBawah_id', '=', 'linerBawah.id')
            ->select('substance.*', 'linerAtas.gramKertas AS linerAtas', 'bf.gramKertas AS bf', 'linerTengah.gramKertas AS linerTengah', 'cf.gramKertas AS cf', 'linerBawah.gramKertas AS linerBawah')
            ->get();
        $box = DB::table('box')->get();
        $colorcombine = DB::table('color_combine')->get();
        $joint = DB::table('joint')->get();
        $koli = DB::table('koli')->get();

        $mc = DB::table('mc')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->leftJoin('substance as subskontrak', 'substanceKontrak_id', '=', 'subskontrak.id')
            ->leftJoin('substance as subsproduksi', 'substanceProduksi_id', '=', 'subsproduksi.id')
            ->leftJoin('color_combine', 'colorcombine_id', '=', 'color_combine.id')
            ->where('mc.id', '=', $id)
            ->select('mc.*','color_combine.id as ccid','color_combine.nama as ccnama','subskontrak.namaMc as subsKontrak','subsproduksi.namaMc as subsProduksi', 'box.panjangDalamBox as panjangDalam','box.lebarDalamBox as lebarDalam','box.tinggiDalamBox as tinggiDalam', 'box.id as box_id' )
            ->first();

        $kodemc = DB::table('mc')
            ->where('kode', '=', $mc->kode)
            ->get();

        $revisi = count($kodemc);
        
        return view('admin.mastercard.edit', compact([
            'item',
            'substance',
            'box',
            'colorcombine',
            'joint',
            'koli',
            'mc',
            'revisi'
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mastercard  $mastercard
     * @return \Illuminate\Http\Response
     */
    public function saveRevisi($id, Request $request)
    {
        $mc = Mastercard::find($id);

        $mc->kode = $request->kode;
        $mc->kodeBarang = $request->kodeBarang;
        $mc->namaBarang = $request->namaBarang;
        $mc->tipeBox = $request->tipebox;
        $mc->CreasCorrP = $request->creasCorr;
        $mc->CreasCorrL = $request->creasConv;
        $mc->joint = $request->joint;
        $mc->flute = $request->flute;
        $mc->lebarSheet = $request->lebarSheet;
        $mc->panjangSheet = $request->panjangSheet;
        $mc->lebarSheetBox = $request->lebarSheetBox;
        $mc->panjangSheetBox = $request->panjangSheetBox;
        $mc->luasSheet = $request->luasSheet;
        $mc->luasSheetBox = $request->luasSheetBox;
        $mc->outConv = $request->outConv;
        $mc->koli = $request->koli;
        $mc->bungkus = $request->bungkus;
        $mc->keterangan = $request->keterangan;
        $mc->wax = $request->wax;
        $mc->tipeMc = $request->tipeMc;
        

    }

    public function pdfprint($id)
    {   
        $mc = DB::table('mc')
            ->leftJoin('substance as SubsProduksi','substanceProduksi_id', '=', 'SubsProduksi.id')
            ->leftJoin('substance as SubsKontrak', 'substanceKontrak_id', '=', 'SubsKontrak.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', 'box.id')
            ->select('mc.*', 'SubsProduksi.namaMc AS SubsProduksiNama', 'SubsKontrak.namaMc AS SubsKontrakNama', 'color_combine.nama AS colComNama', 'box.lebarDalamBox AS lebarDalamBox', 'box.panjangDalamBox AS panjangDalamBox', 'box.tinggiDalamBox AS tinggiDalamBox', 'box.tipeCreasCorr AS tipeCrease', 'box.kuping', 'box.panjangCrease', 'box.lebarCrease1', 'box.lebarCrease2', 'box.flapCrease', 'box.tinggiCrease')
            ->where('mc.id', $id)
            ->first();

        // var_dump($mc->tipebox);
        // $substancKontrak = explode(" ", $mc->SubsKontrakNama);
        // $substancProduksi = explode(" ", $mc->SubsProduksiNama);
        // dd($mc);
        $namaSubsK = $mc->SubsKontrakNama;
        $namaSubsP = $mc->SubsProduksiNama;
        return view('admin.mastercard.pdfb1', compact('mc','namaSubsK','namaSubsP'));
    }

}
