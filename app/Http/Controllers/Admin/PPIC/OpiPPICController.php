<?php

namespace App\Http\Controllers\Admin\PPIC;

use App\Http\Controllers\Controller;
use App\Models\Opi_M;
use Illuminate\Http\Request;

class OpiPPICController extends Controller
{
    public function index()
    {
        return view('admin.ppic.opi.data_opi');
    }

    public function get_opibyperiode(Request $request)
    {
        $filter = Opi_M::opi()->where('opi_m.created_at', 'LIKE', '%2022-10-01%' )->get();
        $opi = Opi_M::opi()->whereBetween('opi_m.created_at', ['2022-10-01', '2022-10-02'])->get();

        if ($opi == NULL) {
            return response()->json(['data' => []]);
        }elseif (!empty($request->mulai) && !empty($request->end)) {
            if ($request->mulai == $request->end) {
                $filter = Opi_M::opi()->where('opi_m.created_at', 'LIKE', '%'.$request->mulai.'%' )->get();
                return response()->json([ 'data' => $filter ]);
            } else {
                $filter = Opi_M::opi()->whereBetween('opi_m.created_at', [$request->mulai, $request->end])->get();
                return response()->json([ 'data' => $filter ]);
            }
        } else {
            return redirect('admin/ppic/opi')->with('success', "masukkan tanggal dengan benar!!!");
        }
    }
}
