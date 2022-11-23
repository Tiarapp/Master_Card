<?php

namespace App\Http\Controllers\Admin\PPIC;

use App\Http\Controllers\Controller;
use App\Models\Kontrak_D;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpiPPICController extends Controller
{
    public function index()
    {
        return view('admin.ppic.opi.data_opi');
    }

    public function get_opibyperiode(Request $request)
    {
        // $filter = Opi_M::opi()->where('opi_m.created_at', 'LIKE', '%2022-10-01%' )->get();
        $opi = Opi_M::opi()->whereBetween('opi_m.created_at', ['2022-10-01', '2022-10-02'])->get();

        if ($opi == NULL) {
            return response()->json(['data' => []]);
        }elseif (!empty($request->mulai) && !empty($request->end)) {
            if ($request->mulai == $request->end) {
                $filter = Opi_M::opi()->where('opi_m.tglKirimDt', 'LIKE', '%'.$request->mulai.'%' )->get();
                return response()->json([ 'data' => $filter ]);
            } else {
                $filter = Opi_M::opi()->whereBetween('opi_m.tglKirimDt', [$request->mulai, $request->end])->get();
                return response()->json([ 'data' => $filter ]);
            }
        } else {
            return redirect('admin/ppic/opi')->with('success', "masukkan tanggal dengan benar!!!");
        }
    }

    public function approve_opi()
    {
        $opi = Opi_M::opidt()->where('status', '=', 'Butuh Approve')
            ->get();

        return view('admin.ppic.opi.data_approve_opi', compact('opi'));
    }

    public function proses_approve($id)
    {
        $opi = Opi_M::opidt()->where('opi_m.id', '=', $id)->first();
        $kontrak = Kontrak_D::where('id', '=', $opi->kontrak_d_id)->first();

        $kontrak->pcsSisaKontrak = $kontrak->pcsKontrak - $opi->jumlahOrder;
        $kontrak->save();

        $opi->status = 'Proses';
        $opi->lastUpdatedBy = Auth::user()->name;

        $opi->save();

        return redirect('admin/ppic/opi_approve');
    }
}
