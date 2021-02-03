<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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
    public function index()
    {
        $mc = DB::table('mc')->get();

        return view('admin.mastercard.index', compact('mc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $nobukti = 2;
        // $number = DB::table('number_sequence')
        //     ->select('format')
        //     ->get();
        // $format1 = $nobukti-1;
        // $temp = $number[$format1];
        // $format2 = $temp->format;
        
        // if ($format2 === $format2) {
        //     $format2 = str_replace('~yyyy~',date('Y'), $format2);
        //     $format2 = str_replace('~mm~',date('m'), $format2);
        //     $result = DB::table('number_sequence')
        //                 ->select(DB::raw('MONTH(created_at) month'))
        //                 ->get();
        //             $count = count($result) +1;
        //     $format2= str_replace('~99999~', str_pad($count, 5, '0', STR_PAD_LEFT), $format2);

        // }

        // $id = 2;
        // $sssh = DB::table('substance_sheet')
        //     ->join('substance', 'substance_sheet.substance_id', '=', 'substance.id')
        //     ->join('sheet', 'substance_sheet.sheet_id', '=', 'sheet.id')
        //     ->select('sheet.lebarSheet', 'sheet.panjangSheet')
        //     ->where('substance_sheet.id', '=', $id)
        //     // ->pluck('sheet.lebarSheet',)
        //     ->get();
        // dd($sssh[0]->lebarSheet);

        $item = DB::table('item_bj')->get();
        $substance = DB::table('substance')
            ->leftJoin('jenis_gram as linerAtas', 'jenisGramLinerAtas_id', '=', 'linerAtas.id')
            ->leftJoin('jenis_gram as bf', 'jenisGramBf_id', '=', 'bf.id')
            ->leftJoin('jenis_gram as linerTengah', 'jenisGramLinerTengah_id', '=', 'linerTengah.id')
            ->leftJoin('jenis_gram as cf', 'jenisGramCf_id', '=', 'cf.id')
            ->leftJoin('jenis_gram as linerBawah', 'jenisGramLinerBawah_id', '=', 'linerBawah.id')
            ->select('substance.*', 'linerAtas.gramKertas AS linerAtas', 'bf.gramKertas AS bf', 'linerTengah.gramKertas AS linerTengah', 'cf.gramKertas AS cf', 'linerBawah.gramKertas AS linerBawah')
            ->get();
        $box = DB::table('box')->get();
        $colorcombine = DB::table('color_combine')->get();
        $joint = DB::table('joint')->get();
        $koli = DB::table('koli')->get();
        
        return view('admin.mastercard.create', compact([
            'item',
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
            'bj_id' => 'required',
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
            'outConv' => 'required',
            'substanceKontrak_id' => 'required',
            'substanceProduksi_id' => 'required',
            'koli' => 'required',
            'bungkus' => 'required',
            'wax' => 'nullable',
            'box_id' => 'required',
            'gramSheetBox' => 'nullable',
            'colorCombine_id' => 'required',
            'keterangan' => 'nullable',
            'gambar'    => 'required|file|mimes:jpeg,png,jpg|max: 1048',
            'createdBy' => 'required',
        ], $messages);

        $file = $request->file('gambar');
        $nama_file = time()."_".$file->getClientOriginalName();

        $tujuan_upload = 'upload';
        $file->move($tujuan_upload, $nama_file);

        Mastercard::create([
            'kode' => $request->kode,
            'bj_id' => $request->bj_id,
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
            'tinggiSheetBox' => $request->tinggiSheetBox,
            'luasSheetBox' => $request->luasSheetBox,
            'substanceKontrak_id' => $request->substanceKontrak_id,
            'substanceProduksi_id' => $request->substanceProduksi_id,
            'mesin' => $request->mesin,
            'outConv' => $request->outConv,
            'koli' => $request->koli,
            'bungkus' => $request->bungkus,
            'wax' => $request->wax,
            'box_id' => $request->box_id,
            'gramSheetBox' => $request->beratSheetBox,
            'colorCombine_id' => $request->colorCombine_id,
            'keterangan' => $request->keterangan,
            'gambar' => $nama_file,
            'createdBy' => $request->createdBy
        ]);

        return redirect('admin/mastercard');
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
    public function edit(Mastercard $mastercard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mastercard  $mastercard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mastercard $mastercard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mastercard  $mastercard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mastercard $mastercard)
    {
        //
    }

    public function pdfprint($id)
    {   
        $mc = Mastercard::find($id, )
            ->leftJoin('item_bj','bj_id','=','item_bj.id')
            ->leftJoin('substance as SubsProduksi','substanceProduksi_id', '=', 'SubsProduksi.id')
            ->leftJoin('substance as SubsKontrak', 'substanceKontrak_id', '=', 'SubsKontrak.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->select('mc.*', 'item_bj.kode AS kodeBrg', 'item_bj.nama AS namaBrg', 'SubsProduksi.nama AS SubsProduksiNama', 'SubsKontrak.nama AS SubsKontrakNama', 'color_combine.nama AS colComNama');

        // var_dump($mc);
        return view('admin.mastercard.pdf', ['mc' => $mc]);
    }

}
