<?php

namespace App\Http\Controllers;

use App\Models\Conv_D;
use App\Models\Conv_M;
use App\Models\Corr_D;
use App\Models\Corr_M;
use App\Models\HasilProduksi;
use App\Models\Mesin;
use App\Models\Opi_M;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HasilProduksiController extends Controller
{
    public function plan_corr(Request $request)
    {
        if ($request->ajax()) {
            $data = Corr_M::get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='inputhasilcorr/".$row->id."' class='edit btn btn-primary btn-sm'>Input Hasil</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);
        }
        // return view('admin.plan.corr.index');
    }

    public function convd_flexo(Request $request)
    {
        if ($request->ajax()) {
            $data = Conv_M::get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='inputhasilconv/".$row->id."' class='edit btn btn-primary btn-sm'>Input Hasil</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            // dd($data);                    
        }
        // return view('admin.plan.corr.index');
    }

    
    public function index_conv()
    {
        return view('admin.plan.hasilconv.indexflexo');
    }

    public function index_corr()
    {
        return view('admin.plan.hasilcorr.index');
    }

    public function index_detail_conv($id)
    {
        $convd = Conv_D::convd()->where('plan_conv_m_id', '=', $id)->get();

        // dd($convd);

        return view('admin.plan.hasilconv.indexdetail', compact('convd'));
    }

    public function index_detail_corr($id)
    {
        $corrm = Corr_M::find($id);

        $corrd = Corr_D::corr()->where('plan_corr_m_id', '=', $corrm->id)->get();

        return view('admin.plan.hasilcorr.indexdetail', compact('corrd'));
    }

    public function input_hasil($id)
    {
        // $opi = Opi_M::opi()->find($id);
        $corr = Corr_D::corr()->find($id);
        $mesin = 'CORR';
        // $datamesin = Mesin::get();

        // dd($corr);
        return view('admin.plan.hasilcorr.edit', compact('corr','mesin'));
    }

    public function input_hasil_conv($id)
    {
        // $opi = Opi_M::opi()->find($id);
        $conv = Conv_D::convd()->find($id);
        $mesin = Mesin::get();

        // dd($conv);
        return view('admin.plan.hasilconv.edit', compact('conv','mesin'));
    }

    public function hasil_produksi(Request $request)
    {

        if ($request->mesin == "CORR") {
            $hasil = HasilProduksi::create([
                'opi_id' => $request->opi_id,
                'corr_id' => $request->plan_id,
                'noOpi' => $request->nama_opi,
                'start_date' => $request->start,
                'end_date' => $request->end,
                'hasil_baik' => $request->baik,
                'tonase_baik' => $request->tonase_baik,
                'hasil_jelek' => $request->jelek,
                'tonase_jelek' => $request->tonase_jelek,
                'mesin' => $request->mesin,
                'keterangan' => $request->keterangan,
                'downtime' => $request->downtime,
                'durasi' => $request->durasi,
                'palet' => $request->palet
            ]);
            return redirect('admin/produksi/inputhasilcorr/'.$request->idurl);

        } else {
            $hasil = HasilProduksi::create([
                'opi_id' => $request->opi_id,
                'conv_id' => $request->plan_id,
                'noOpi' => $request->nama_opi,
                'start_date' => $request->start,
                'end_date' => $request->end,
                'hasil_baik' => $request->baik,
                'tonase_baik' => $request->tonase_baik,
                'hasil_jelek' => $request->jelek,
                'tonase_jelek' => $request->tonase_jelek,
                'mesin' => $request->mesin,
                'keterangan' => $request->keterangan,
                'downtime' => $request->downtime,
                'durasi' => $request->durasi,
                'palet' => $request->palet
            ]);

            if ($request->mesin == 'STB') {
                $opi = Opi_M::find($request->opi_id);
                $opi->sisa_order = $opi->jumlahOrder - $request->baik;
                $opi->save();
            }
            return redirect('admin/produksi/inputhasilconv/'.$request->idurl);
        }

    }

}
