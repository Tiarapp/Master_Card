<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Opi_M;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        $data = Opi_M::opi2()->get();
        return Datatables::of($data)->make(true);
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Opi_M::opi2()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = "<a href='../admin/opi/edit/".$row->opiid."' class='edit btn btn-primary btn-sm'>View</a>
                        <a href='../admin/opi/print/".$row->opiid."' class='btn btn-outline-secondary' type='button'>Print</a>";

                        return $btn;
                    })
                    ->addColumn('hari', function($row){
                        $day = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU"];
                        $hari = $day[date('w', strtotime($row->tglKirimDt))];

                        return $hari;
                    })
                    ->addColumn('toleransi', function($row){
                        $lebih = $row->toleransiLebih;
                        $kurang = $row->toleransiKurang;

                        $toleransi = $lebih.'/'.$kurang;

                        return $toleransi;
                    })
                    ->rawColumns(['action','hari','toleransi'])
                    ->make(true);
            // dd($data);                    
        }
        // $data = Opi_M::opi2();
        // dd($data);
        return view('admin.opi.index');
        // $kontrak_m = Kontrak_M::get();

        // return view('admin.kontrak.index',compact('kontrak_m'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $opi_m = DB::table('opi_m')->get();
        $alphabet = "A";
        $numb_opi = str_pad(count($opi_m)+3200+1,4, '0', STR_PAD_LEFT).$alphabet;

        // dd($numb_opi);

        $kontrak_d = DB::table('kontrak_d')
            ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            // ->leftJoin('dt', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('kontrak_d.*','kontrak_m.kode as noKontrak', 'kontrak_m.tglKontrak as tglOrder', 'kontrak_m.tipeOrder as tipeOrder', 'kontrak_m.poCustomer as poCust', 'kontrak_m.customer_name as namaCust', 'kontrak_m.alamatKirim as alamatKirim', 'kontrak_m.keterangan as keterangan', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'substance.namaMc as substance', 'mc.kode as nomc', 'mc.kodeBarang as kodeBarang', 'mc.namaBarang as namaBarang', 'mc.flute as flute', 'color_combine.nama as warna', 'mc.outConv as outConv', 'mc.gramSheetCorrKontrak as berat' , 'mc.koli as koli', 'mc.joint as joint', 'mc.tipeBox as bentuk', 'mc.id as mcid', 'kontrak_m.id as kontrakmid',  )
            ->get();

        $dt = DB::table('dt')->get();

        // dd($kontrak_d);
        return view('admin.opi.create', compact('kontrak_d', 'dt', 'numb_opi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $day = date("D", $request->tglKirimDt);

        $opim = Opi_M::create([   
            'nama' => $request->noOpi,
            'NoOPI' => $request->noOpi,
            'dt_id' => $request->dtid,
            'mc_id' => $request->mcid,
            'kontrak_m_id' => $request->kontrakmid,
            'kontrak_d_id' => $request->kontrakdid,
            'keterangan' => $request->keterangan,
            'tglKirimDt' => $request->tglKirim,
            'jumlahOrder' => $request->jumlahOrder,
            'hariKirimDt' => $day,
            'createdBy' => Auth::user()->name,
        ]);

        return redirect('admin/opi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function show(Opi_M $opi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function edit(Opi_M $opi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opi_M $opi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $opi = DB::table('opi_m')
            ->leftJoin('dt', 'dt_id', 'dt.id')
            ->leftJoin('mc', 'mc_id', 'mc.id')
            ->leftJoin('box', 'mc.box_id', 'box.id')
            ->leftJoin('substance', 'mc.substanceProduksi_id', 'substance.id')
            ->leftJoin('color_combine', 'mc.colorCombine_id', 'color_combine.id')
            ->where('opi_m.id', '=', $id)
            ->select('opi_m.noOPI', 'opi_m.jumlahOrder', 'opi_m.keterangan', 'mc.namaBarang', 'opi_m.nama', 'mc.revisi', 'mc.kodeBarang', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'substance.kode as subsKode', 'box.flute', 'color_combine.nama as namacc', 'mc.gramSheetBoxProduksi2 as gram', 'mc.koli', 'mc.joint', 'mc.tipeBox', 'mc.kode as mcKode', 'dt.pcsDt', 'dt.tglKirimDt', 'mc.outConv' )
            ->first();

        $opi2 = DB::table('opi_m')
        ->leftJoin('kontrak_m', 'kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('kontrak_d', 'kontrak_d_id', 'kontrak_d.id')
        ->where('opi_m.id', '=', $id)
        ->select('kontrak_m.kode', 'kontrak_m.tglKontrak', 'kontrak_m.customer_name as Cust', 'kontrak_m.poCustomer', 'kontrak_m.alamatKirim', 'kontrak_d.pctToleransiKurangKontrak', 'kontrak_d.pctToleransiLebihKontrak', 'kontrak_m.tipeOrder' )
        ->first();


            // var_dump();

        return view('admin.opi.pdf', compact('opi','opi2'));
    }
}
