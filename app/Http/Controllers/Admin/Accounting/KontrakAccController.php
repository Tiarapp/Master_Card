<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Mastercard;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontrakAccController extends Controller
{
    public function index()
    {
        return view('admin.acc.data_kontrak');
    }

    public function get_opibyperiode(Request $request)
    {
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
    
    public function json(Request $request)
        {

            // dd($request->periode);
            $kontrak = Kontrak_M::where('kode', 'LIKE', '%'.$request->periode.'%')
                ->where('status', '=', 4)
                ->get();           
            
            // dd($kontrak);
            $data = array();
            if (!empty($kontrak)) {
                foreach ($kontrak as $kontrak)
                {
                    $nestedData['kode'] = $kontrak->kode;
                    $nestedData['tglKontrak'] = $kontrak->tglKontrak;
                    $nestedData['pcsKontrak'] = $kontrak->kontrak_d->pcsKontrak;
                    $nestedData['cust'] = $kontrak->customer_name;
                    $nestedData['poCustomer'] = $kontrak->poCustomer;
                    $nestedData['top'] = $kontrak->top;

                    $kirim = 0;

                    if ($kontrak->realisasi != null) {
                        foreach ($kontrak->realisasi as $realisasi) {
                            $kirim = $kirim + $realisasi->qty_kirim;
                        }
                    }

                    $nestedData['kirim'] = $kirim;

                    if ($kontrak->komisi == '') {
                        $komisi = 0 ;
                    } else {
                        $komisi = $kontrak->komisi;
                    }

                    $nestedData['komisi'] = $komisi;
                    $nestedData['sales'] = $kontrak->sales;
                    
                    $mc = Mastercard::find($kontrak->kontrak_d->mc_id);

                    // $nestedData['namaBarang'] = $mc->namaBarang;
                    
                    $data[] = $nestedData;
                }
            }

            // dd($data);
            
            $json_data = array(
                "draw"            => intval($request->input('draw')),  
                // "recordsTotal"    => intval($totalData),  
                // "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data,
            );
            
            // dd($json_data);
            echo json_encode($json_data); 
        }
}