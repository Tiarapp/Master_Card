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
        $mc = DB::table('mc_view')->get();

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
        $boxes = DB::table('box')->get();
        $sheet = DB::table('sheet')->get();
        $flute = DB::table('flute')->get();
        
        return view('admin.mastercard.create', compact([
            'item',
            'boxes',
            'sheet',
            'flute'
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
        //
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

    public function generateNumberSequence()
    {   
        

        
    }

}
