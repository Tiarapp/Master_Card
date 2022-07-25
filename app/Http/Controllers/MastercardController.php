<?php

namespace App\Http\Controllers;

use App\Models\Mastercard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // ->where('tipeBox', '!=', 'DC')
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
        $item = DB::connection('firebird2')->table('TBarangConv')->get();
        
        $cust = DB::connection('firebird')->table('TCustomer')->get();
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
            'item',
            'cust',
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


        Mastercard::create([
            'kode' => $request->kode,
            'revisi' => "R0",
            'customer' => $request->customer,
            'tipeCust' => $request->golongan,
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
            'luasSheetProd' => $request->luasSheetProd,
            'luasSheetBoxProd' => $request->luasSheetBoxProd,
            'panjangSheetBox' => $request->panjangSheetBox,
            'lebarSheetBox' => $request->lebarSheetBox,
            'luasSheetBox' => $request->luasSheetBox,
            'substanceKontrak_id' => $request->substanceKontrak_id,
            'substanceProduksi_id' => $request->substanceProduksi_id,
            'tipeMc' => $request->tipeMc,
            'mesin' => $request->mesin,
            'outConv' => $request->outConv,
            'brt_kualitas' => $request->gram_kualitas,
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
        $cust = DB::connection('firebird')->table('TCustomer')->get();
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
         
            // dd($mc->tipeCust);
            // $tipe = null;
            if ($mc->tipeCust === "000") {
                $tipe = "Sheet";
            }elseif ($mc->tipeCust === "001") {
                $tipe = "Food and Baverage";
            }elseif ($mc->tipeCust === "002") {
                $tipe = "Keramik";
            }elseif ($mc->tipeCust === "003") {
                $tipe = "Frozen";
            }elseif ($mc->tipeCust === "004") {
                $tipe = "Oil";
            }elseif ($mc->tipeCust === "005") {
                $tipe = "Plasik";
            }elseif ($mc->tipeCust === "006") {
                $tipe = "DOC";
            }elseif ($mc->tipeCust === "007") {
                $tipe = "Tissue";
            }elseif ($mc->tipeCust === "999") {
                $tipe = "Others";
            } else {
                $tipe = "";
            }

            // dd($tipe);
        $kodemc = DB::table('mc')
            ->where('kode', '=', $mc->kode)
            ->get();

        $revisi = count($kodemc);
        
        return view('admin.mastercard.edit', compact([
            'item',
            'cust',
            'tipe',
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
            'gambar'    => 'required|file|mimes:jpeg,png,jpg|max: 1048',
            'createdBy' => 'required',
        ], $messages);

        $file = $request->file('gambar');
        if ($file != null) {
            $nama_file = time()."_".$file->getClientOriginalName();

            $tujuan_upload = 'upload';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = $request->old;
        }

        // dd($nama_file);
        // $file = $request->file('gambar');
        // $nama_file = time()."_".$file->getClientOriginalName();

        // $tujuan_upload = 'upload';
        // $file->move($tujuan_upload, $nama_file);

        Mastercard::create([
            'kode' => $request->kode,
            'revisi' => "R".$request->revisi,
            'customer' => $request->customer,
            'tipeCust' => $request->golongan,
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
            'luasSheetProd' => $request->luasSheetProd,
            'luasSheetBoxProd' => $request->luasSheetBoxProd,
            'panjangSheetBox' => $request->panjangSheetBox,
            'lebarSheetBox' => $request->lebarSheetBox,
            'luasSheetBox' => $request->luasSheetBox,
            'substanceKontrak_id' => $request->substanceKontrak_id,
            'substanceProduksi_id' => $request->substanceProduksi_id,
            'tipeMc' => $request->tipeMc,
            'mesin' => $request->mesin,
            'outConv' => $request->outConv,
            'brt_kualitas' => $request->gram_kualitas,
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
        $cust = DB::connection('firebird')->table('TCustomer')->get();
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


        if ($mc->revisi === '') {
            $revisi = 0;
        } else {
            $revisi = preg_replace("/[^0-9]/","",$mc->revisi);
        }

        if ($mc->tipeCust === "000") {
            $tipe = "Sheet";
        }elseif ($mc->tipeCust === "001") {
            $tipe = "Food and Baverage";
        }elseif ($mc->tipeCust === "002") {
            $tipe = "Keramik";
        }elseif ($mc->tipeCust === "003") {
            $tipe = "Frozen";
        }elseif ($mc->tipeCust === "004") {
            $tipe = "Oil";
        }elseif ($mc->tipeCust === "005") {
            $tipe = "Plasik";
        }elseif ($mc->tipeCust === "006") {
            $tipe = "DOC";
        }elseif ($mc->tipeCust === "007") {
            $tipe = "Tissue";
        }elseif ($mc->tipeCust === "999") {
            $tipe = "Others";
        } else {
            $tipe = "";
        }
        
        return view('admin.mastercard.revisi', compact([
            'cust',
            'item',
            'tipe',
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
        if($request->revisi == null){
            $rev = null;
        } else {
            $rev = "R".$request->revisi;
        }

        $file = $request->file('gambar');
        if ($file != null) {
            $nama_file = time()."_".$file->getClientOriginalName();

            $tujuan_upload = 'upload';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = $request->old;
        }

        // dd($nama_file);

        // dd($rev);
        $mc->kode = $request->kode;
        $mc->revisi = $rev;
        $mc->kodeBarang = $request->kodeBarang;
        $mc->namaBarang = $request->namaBarang;
        $mc->customer = $request->customer;
        $mc->tipeCust = $request->golongan;
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
        $mc->luasSheetProd = $request->luasSheetProd;
        $mc->luasSheetBoxProd = $request->luasSheetBoxProd;
        $mc->outConv = $request->outConv;
        $mc->brt_kualitas = $request->gram_kualitas;
        $mc->koli = $request->koli;
        $mc->bungkus = $request->bungkus;
        $mc->keterangan = $request->keterangan;
        $mc->wax = $request->wax;
        $mc->tipeMc = $request->tipeMc;
        $mc->substanceKontrak_id = $request->substanceKontrak_id;
        $mc->substanceProduksi_id = $request->substanceProduksi_id;
        $mc->gramSheetBoxKontrak2 = $request->gramSheetBoxKontrak2;
        $mc->gramSheetBoxProduksi2 = $request->gramSheetBoxProduksi2;
        $mc->gramSheetCorrKontrak2 = $request->gramSheetCorrKontrak2;
        $mc->gramSheetCorrProduksi2 = $request->gramSheetCorrProduksi2;
        $mc->gramSheetBoxKontrak = $request->gramSheetBoxKontrak;
        $mc->gramSheetBoxProduksi = $request->gramSheetBoxProduksi;
        $mc->gramSheetCorrKontrak = $request->gramSheetCorrKontrak;
        $mc->gramSheetCorrProduksi = $request->gramSheetCorrProduksi;
        $mc->box_id = $request->box_id;
        $mc->colorCombine_id = $request->colorCombine_id;
        $mc->lastUpdatedBy = Auth::user()->name;
        $mc->gambar = $nama_file;

       $mc->save();

        return redirect('admin/mastercard/b1');
        

    }

    public function pdfprint($id)
    {   
        $mc = DB::table('mc')
            ->leftJoin('substance as SubsProduksi','substanceProduksi_id', '=', 'SubsProduksi.id')
            ->leftJoin('substance as SubsKontrak', 'substanceKontrak_id', '=', 'SubsKontrak.id')
            ->leftJoin('jenis_gram as linerAtasK', 'SubsKontrak.jenisGramLinerAtas_id', '=', 'linerAtasK.id')
            ->leftJoin('jenis_gram as bfK', 'SubsKontrak.jenisGramFlute1_id', '=', 'bfK.id')
            ->leftJoin('jenis_gram as linerTengahK', 'SubsKontrak.jenisGramLinerTengah_id', '=', 'linerTengahK.id')
            ->leftJoin('jenis_gram as cfK', 'SubsKontrak.jenisGramFlute2_id', '=', 'cfK.id')
            ->leftJoin('jenis_gram as linerBawahK', 'SubsKontrak.jenisGramLinerBawah_id', '=', 'linerBawahK.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('jenis_gram as linerAtasP', 'SubsProduksi.jenisGramLinerAtas_id', '=', 'linerAtasP.id')
            ->leftJoin('jenis_gram as bfP', 'SubsProduksi.jenisGramFlute1_id', '=', 'bfP.id')
            ->leftJoin('jenis_gram as linerTengahP', 'SubsProduksi.jenisGramLinerTengah_id', '=', 'linerTengahP.id')
            ->leftJoin('jenis_gram as cfP', 'SubsProduksi.jenisGramFlute2_id', '=', 'cfP.id')
            ->leftJoin('jenis_gram as linerBawahP', 'SubsProduksi.jenisGramLinerBawah_id', '=', 'linerBawahP.id')
            ->leftJoin('box', 'box_id', 'box.id')
            ->select('mc.*', 'SubsProduksi.namaMc AS SubsProduksiNama', 'SubsKontrak.namaMc AS SubsKontrakNama', 'color_combine.nama AS colComNama', 'box.lebarDalamBox AS lebarDalamBox', 'box.panjangDalamBox AS panjangDalamBox', 'box.tinggiDalamBox AS tinggiDalamBox', 'box.tipeCreasCorr AS tipeCrease', 'box.kuping', 'box.panjangCrease', 'box.lebarCrease1', 'box.lebarCrease2', 'box.flapCrease', 'box.tinggiCrease', 'linerAtasK.gramKertas as AtasK', 'bfK.gramKertas as bfK', 'linerTengahK.gramKertas as TengahK', 'cfK.gramKertas as cfK', 'linerBawahK.gramKertas as linerBawahK', 'linerAtasP.gramKertas as AtasP', 'bfP.gramKertas as bfP', 'linerTengahP.gramKertas as TengahP', 'cfP.gramKertas as cfP', 'linerBawahP.gramKertas as linerBawahP')
            ->where('mc.id', $id)
            ->first();
        // dd($mc);
        // var_dump($mc->tipebox);
        // $substancKontrak = explode(" ", $mc->SubsKontrakNama);
        // $substancProduksi = explode(" ", $mc->SubsProduksiNama);
        // dd($mc);
        $namaSubsK = $mc->SubsKontrakNama;
        $namaSubsP = $mc->SubsProduksiNama;
        return view('admin.mastercard.print', compact('mc','namaSubsK','namaSubsP'));
    }

}
