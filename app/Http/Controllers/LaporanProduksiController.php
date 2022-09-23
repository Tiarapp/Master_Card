<?php

namespace App\Http\Controllers;

use App\Models\HasilProduksi;
use App\Models\Mesin;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanProduksiController extends Controller
{
    public function index()
    {
            $mesin = Mesin::all();
            $laporan_produksi = HasilProduksi::all();

        return view('admin.produksi.index', compact('laporan_produksi', 'mesin'));
    }

    public function get_filter(Request $request){
        $lap = HasilProduksi::all();
        

        if ($lap == NULL) {
            return response()->json([ 'data' => [] ]);
        } else {
            if (empty($request->mulai) && empty($request->end)) {

                if (!empty($request->mesin)) {
                    $filter = HasilProduksi::
                    where('mesin', '=', $request->mesin)
                    ->get();

                    // dd($filter);
                    return response()->json([ 'data' => $filter]);
                }
            } else {
                if (empty($request->mesin)) {
                    $filter = HasilProduksi::
                    whereBetween('start_date', [$request->mulai, $request->end])
                    ->get();
                    
                    // dd($filter);

                    return response()->json([ 'data' => $filter ]);
                } else {
                    $filter = HasilProduksi::
                    whereBetween('start_date', [$request->mulai, $request->end])
                    ->where('mesin', '=', $request->mesin)  
                    ->get();
                    
                    // dd($filter);

                    return response()->json([ 'data' => $filter ]);
                }
            }
        }
    }
}
