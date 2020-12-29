<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoCompleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $barang = [];

        if($request->has('q')){
            $search = $request->q;
            $barang = Barang::select('KodeBrg', 'NamaBrg')
                ->where('NamaBrg', 'LIKE', "%$search%")
                ->get();
        
        return response()->json($barang);
        }
    }

}
