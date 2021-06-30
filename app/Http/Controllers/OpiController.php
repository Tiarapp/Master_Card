<?php

namespace App\Http\Controllers;

use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Opi;
use App\Models\Opi_M;
use Carbon\Carbon;
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
    public function index()
    {
        $opi_m = DB::table('opi_m')
            ->get();

        return view('admin.opi.index', compact('opi_m'));
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
        $numb_opi = str_pad(count($opi_m)+1,4, '0', STR_PAD_LEFT).$alphabet;

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
            'pcsDt' => $request->jumlahOrder,
            'kgDt' => $request->kgKirim,
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
    public function show(Opi $opi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function edit(Opi $opi)
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
    public function update(Request $request, Opi $opi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opi  $opi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opi $opi)
    {
        //
    }
}
