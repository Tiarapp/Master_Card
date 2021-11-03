<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use Carbon\Carbon;
use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

class Kontrak_DController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function json()
    // {
    //     return Datatables::of(Kontrak_M::all())->make(true);
    // }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kontrak_M::select('*');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $btn = "<a href='../admin/kontrak/edit/".$row->id."' class='edit btn btn-primary btn-sm'>View</a>
                <a href='../admin/kontrak/pdf/".$row->id."' class='btn btn-outline-secondary' type='button'>Print</a>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);                    
        }

        
        return view('admin.kontrak.index');
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

        $cust = DB::connection('firebird')->table('TCustomer')->get();
        $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            // ->where('id', '=', $variable)->orderBy('id', '=', 'ASC')
            ->get();
        $top = DB::table('top')->get();
        $sales = DB::table('sales_m')->get();
        
        // menampilkan halaman form input dengan passing data dari query diatas

        // $tgl1 = '17-02-2021 12:00:00';
        // $tgl2 = '20-02-2021 12:30:00';

        // $selisih = (strtotime($tgl2) -  strtotime($tgl1))/60;
        // // $hari = $selisih/(60*60*24);
        // var_dump($selisih);

        return view('admin.kontrak.create', compact(
            'mc', 'top', 'cust', 'sales'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ambil url/ No Bukti halaman
        $url = Route::currentRouteName(); //output kontrak.store

        //ambil noBukti dari number_sequence table
        $ns = DB::table('number_sequence')
        ->select('format')
        ->where('noBukti', '=', $url)->get(); //ambil format yg sesuai url/nobukti
        
        $nobukti = $ns[0]->format;
        $tanggal = $request->tanggal;

        // dd($nobukti, $tanggal);

        $start = Carbon::createFromFormat('Y-m-d', $tanggal)
            ->firstOfMonth()
            ->format('Y-m-d');

        $end = Carbon::createFromFormat('Y-m-d', $tanggal)
        ->endOfMonth()
        ->format('Y-m-d');

        $fromDate = Carbon::now()->startOfMonth();
        $tillDate = Carbon::now()->endOfMonth();

        if (strpos($fromDate, $start) !== false ) {
            $result = Kontrak_M::whereBetween(DB::raw('date(tglKontrak)'), [$fromDate, $tillDate])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YYYY~', date('Y'), $nobukti);
                $nobukti = str_replace('~MM~', date('m'), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        } else {
            $result = Kontrak_M::whereBetween(DB::raw('date(tglKontrak)'), [$start, $end])->get();
            $count = count($result)+1;
            if ($nobukti === $nobukti) {
                $nobukti = str_replace('~YYYY~', date('Y', strtotime($start)), $nobukti);
                $nobukti = str_replace('~MM~', date('m', strtotime($start)), $nobukti);                
                $nobukti = str_replace('~999~', str_pad($count, 3, '0', STR_PAD_LEFT), $nobukti);
            }
        }


        // // dd($nobukti);

        // Insert Into ke table
        $kontrakm = Kontrak_M::create([   
            'kode' => $nobukti,
            'tglKontrak' => $request->tanggal,
            'top' => $request->top,
            'poCustomer' => $request->poCustomer,
            'customer_name' => $request->namaCust,
            'alamatKirim' => $request->alamatKirim,
            'caraKirim' => $request->caraKirim,
            'sales' => $request->sales,
            'tipeOrder' => $request->tipeOrder,
            'createdBy' => $request->createdBy,
            'keterangan' => $request->keterangan
        ]);
        // End Insert Into

        // dd($kontrakm);

        $tax = 0 ;
        $sblTax = 0 ;
        $total = 0 ;
        for ($i=1; $i < 6; $i++) { 
            if ($request->idmcpel[$i] !== null) {
                $kontrakd = Kontrak_D::create([
                    'kontrak_m_id' => $kontrakm->id,
                    'mc_id' => $request->idmcpel[$i],
                    'pcsKontrak' => $request->qtyPcs[$i],
                    'pcsSisaKontrak' => $request->qtyPcs[$i],
                    'kgKontrak' => $request->qtyKg[$i],
                    'kgSisaKontrak' => $request->qtyPcs[$i],
                    'pctToleransiLebihKontrak' => $request->toleransiLebih[$i],
                    'pctToleransiKurangKontrak' => $request->toleransiKurang[$i],
                    'pcsLebihToleransiKontrak' => $request->pcsToleransiLebih[$i],
                    'kgLebihToleransiKontrak' => $request->kgToleransiLebih[$i],
                    'pcsKurangToleransiKontrak' => $request->pcsToleransiKurang[$i],
                    'kgKurangToleransiKontrak' => $request->kgToleransiKurang[$i],
                    'harga_pcs' => $request->harga[$i],
                    'tax' => $request->tax[$i],
                    'amountBeforeTax' => $request->totalSblTax[$i],
                    'ppn' => $request->hargaTax[$i],
                    'amountTotal' => $request->Total[$i],
                    'harga_kg' => $request->hargaKg[$i],
                    'createdBy' => $request->createdBy,
                    ]);

                    $tax = $tax + $request->hargaTax[$i];
                    $sblTax = $sblTax + $request->totalSblTax[$i];
                    $total = $total + $request->Total[$i];
                    // dd($tax);
                }
            }

            $upMaster = Kontrak_M::find($kontrakm->id); // finding row sesuai id untuk update ke table

            $upMaster->amountBeforeTax = $sblTax; // update database field amountBefireTax dengan value sblTax
            $upMaster->tax = $tax;
            $upMaster->amountTotal = $total;

            $upMaster->save(); // simpan ke table

            for ($i=1; $i < 6; $i++) { 
                if ($request->tglKirim[$i] !== null) {
                    $dt = DeliveryTime::create([
                        'kontrak_m_id' => $kontrakm->id,
                        'kodeKontrak' => $kontrakm->kode,
                        'tglKirimDt' => $request->tglKirim[$i],
                        'pcsDt' => $request->dtPcs[$i],
                        // 'kgDt' => $request->dtKg[$i],
                        'createdBy' => $request->createdBy,
                    ]);
                }
            }


        return redirect('admin/kontrak');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function show(Kontrak_D $kontrak_D)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // menampilkan untuk dropdown
        $cust = DB::connection('firebird')->table('TCustomer')->get();
        
        $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            ->get();
        $top = DB::table('top')->get();
        $sales = DB::table('sales_m')->get();
        // End Dropdown


        // tampilkan data yang akan di edit
        $kontrak_D = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.tipeMc as tipeMc', 'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', )
            ->get();

        $kontrak_M = DB::table('kontrak_m')
            ->where('kontrak_m.id', '=', $id)
            ->first();
        // End tampilkan untuk edit


        // dd($kontrak_M);
        $count = count($kontrak_D);


        // dd($kontrak_M);
        return view('admin.kontrak.edit', compact(
            'cust',
            'mc',
            'top',
            'sales',
            'count',
            'kontrak_D'
        ), ['kontrak_M' => $kontrak_M]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kontrakm =Kontrak_M::find($id);

        // untuk set value yang di update
        $kontrakm->customer_name = $request->namaCust;
        $kontrakm->alamatKirim = $request->alamatKirim;
        $kontrakm->custTelp = $request->telp;
        $kontrakm->poCustomer = $request->poCustomer;
        $kontrakm->tipeOrder = $request->tipeOrder;
        $kontrakm->tglKontrak = $request->tanggal;
        $kontrakm->sales = $request->sales;
        $kontrakm->top = $request->top;
        $kontrakm->caraKirim = $request->caraKirim;
        $kontrakm->keterangan = $request->keterangan;
        // End untuk set value yang di update

        $kontrakm->save();

        // dd($kontrakm);

        $tax = 0 ;
        $sblTax = 0 ;
        $total = 0 ;

        for ($i=0; $i<5 ; $i++) {
            if (isset($request->detail[$i]) != false) {
                $kontrakd =Kontrak_D::find($request->detail[$i]);

                $kontrakd->kontrak_m_id = $kontrakm->id;
                $kontrakd->mc_id = $request->idmcpel[$i];
                $kontrakd->pcsKontrak = $request->qtyPcs[$i];
                $kontrakd->kgKontrak = $request->qtyKg[$i];
                $kontrakd->pctToleransiLebihKontrak = $request->toleransiLebih[$i];
                $kontrakd->pctToleransiKurangKontrak = $request->toleransiKurang[$i];
                $kontrakd->pcsLebihToleransiKontrak = $request->pcsToleransiLebih[$i];
                $kontrakd->kgLebihToleransiKontrak = $request->kgToleransiLebih[$i];
                $kontrakd->pcsKurangToleransiKontrak = $request->pcsToleransiKurang[$i];
                $kontrakd->kgKurangToleransiKontrak = $request->kgToleransiKurang[$i];
                $kontrakd->harga = $request->harga[$i];
                $kontrakd->amountBeforeTax = $request->totalSblTax[$i];
                $kontrakd->ppn = $request->hargaTax[$i];
                $kontrakd->tax = $request->tax[$i];
                $kontrakd->amountTotal = $request->Total[$i];
                $kontrakd->harga_kg = $request->hargaKg[$i];

                $kontrakd->save();
                
            } 
            else 
            {
                if (isset($request->idmcpel[$i]) !== false) {
                    // untuk Insert Into dihalaman edit detail kontrak
                    Kontrak_D::create([
                        'kontrak_m_id' => $kontrakm->id,
                        'mc_id' => $request->idmcpel[$i],
                        'pcsKontrak' => $request->qtyPcs[$i],
                        'pcsSisaKontrak' => $request->qtyPcs[$i],
                        'kgKontrak' => $request->qtyKg[$i],
                        'kgSisaKontrak' => $request->qtyPcs[$i],
                        'pctToleransiLebihKontrak' => $request->toleransiLebih[$i],
                        'pctToleransiKurangKontrak' => $request->toleransiKurang[$i],
                        'pcsLebihToleransiKontrak' => $request->pcsToleransiLebih[$i],
                        'kgLebihToleransiKontrak' => $request->kgToleransiLebih[$i],
                        'pcsKurangToleransiKontrak' => $request->pcsToleransiKurang[$i],
                        'kgKurangToleransiKontrak' => $request->kgToleransiKurang[$i],
                        'harga' => $request->harga[$i],
                        'tax' => $request->tax[$i],
                        'amountBeforeTax' => $request->totalSblTax[$i],
                        'ppn' => $request->hargaTax[$i],
                        'amountTotal' => $request->Total[$i],
                        'createdBy' => $request->createdBy,
                        'harga_kg' => $request->hargaKg[$i],
                    ]);

                    // var_dump(isset($request->idmcpel[$i]));
                    
                    // End untuk Insert Into dihalaman edit detail kontrak
                    
                    // dd($request->idmcpel[$i]);
                }
            }

            $tax = $tax + $request->hargaTax[$i];
            $sblTax = $sblTax + $request->totalSblTax[$i];
            $total = $total + $request->Total[$i];

        }
        
        // var_dump($tax);
        return redirect('admin/kontrak');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kontrak_D  $kontrak_D
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kontrak_D $kontrak_D)
    {
        //
    }

    public function pdfprint($id){

        // $cust = DB::connection('firebird')->table('TCustomer')->get();
        // $mc = DB::table('mc')->where('tipeMC', '=', 'BOX')
        //     ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
        //     ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
        //     ->leftJoin('box', 'box_id', '=', 'box.id')
        //     ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
        //     ->get();
        // $mcpel = DB::table('mc')->where('tipeMC', '!=', 'BOX')
        // ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
        // ->select('mc.*', 'substance.kode as substancePel')
        // ->get();
        // $top = DB::table('top')->get();
        // $sales = DB::table('sales_m')->get();

        // $kontrak_D = DB::table('kontrak_d')
        //     ->leftJoin('mc', 'mc_id', '=', 'mc.id')
        //     ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
        //     ->where('kontrak_m_id', '=', $id)
        //     ->select('kontrak_d.*', 'mc.kode as mc', 'mc.gramSheetBoxKontrak as gram', 'mc.panjangSheetBox as panjangSheetBox', 'mc.lebarSheetBox as lebarSheetBox','substance.kode as substance', 'mc.flute as flute', 'mc.namaBarang as Barang')
        //     ->get();

        // $kontrak_M = DB::table('kontrak_m')
        //     ->where('kontrak_m.id', '=', $id)
        //     // ->leftJoin('mc', 'mc_id', '=', 'mc.id')
        //     // ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
        //     // ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
        //     // ->leftJoin('box', 'box_id', '=', 'box.id')
        //     // ->select('kontrak_m.*', 'mc.id as mcid', 'mc.kode as mckode', 'mc.namaBarang as namaBarang', 'mc.panjangSheetBox as panjangSheetBox', 'mc.lebarSheetBox as lebarSheetBox', 'mc.gramSheetCorrKontrak as gramSheetCorrKontrak', 'mc.flute as flute', 'mc.tipeBox as tipeBox', 'mc.koli as koli', 'mc.wax as wax', 'mc.joint as joint', 'mc.bungkus as bungkus', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
        //     ->first();

        // // dd($kontrak_M);
        // $count = count($kontrak_D);


        // // dd($kontrak_M);
        // return view('admin.kontrak.pdf', compact(
        //     'cust',
        //     'mc',
        //     'mcpel',
        //     'top',
        //     'sales',
        //     'count',
        //     'kontrak_D'
        // ), ['kontrak_M' => $kontrak_M]);

        $cust = DB::connection('firebird')->table('TCustomer')->get();
        
        $mc = DB::table('mc')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->select('mc.*', 'substance.kode as substance', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease')
            ->get();
        $top = DB::table('top')->get();
        $sales = DB::table('sales_m')->get();
        // End Dropdown


        // tampilkan data yang akan di edit
        $kontrakBox = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->leftJoin('color_combine', 'colorCombine_id', '=', 'color_combine.id')
            ->leftJoin('box', 'box_id', '=', 'box.id')
            ->where('tipe', '=', 'BOX')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.wax as wax', 'mc.tipeMc as tipeMc', 'mc.panjangSheetBox as panjangSheetBox', 'mc.lebarSheetBox as lebarSheetBox',  'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', 'mc.namaBarang as Barang', 'color_combine.nama as warna', 'box.tipeCreasCorr as tipeCrease', 'mc.flute as flute', 'mc.tipeBox as tipeBox', 'mc.koli as koli', 'mc.joint as joint', 'mc.bungkus as bungkus', 'mc.keterangan as keterangan')
            ->first();
        // dd($kontrakBox);


        $kontrak_D = DB::table('kontrak_d')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->leftJoin('substance', 'substanceKontrak_id', '=', 'substance.id')
            ->where('tipe', '!=', 'BOX')
            ->where('kontrak_m_id', '=', $id)
            ->select('kontrak_d.*', 'mc.kode as mc', 'mc.id as mcid', 'mc.wax as wax', 'mc.tipeMc as tipeMc', 'mc.panjangSheetBox as panjangSheetBox', 'mc.lebarSheetBox as lebarSheetBox',  'mc.gramSheetBoxKontrak as gram', 'substance.kode as substance', 'mc.namaBarang as Barang', 'mc.flute as flute', 'mc.tipeBox as tipeBox', 'mc.koli as koli', 'mc.joint as joint', 'mc.bungkus as bungkus')
            ->get();

        $kontrak_M = DB::table('kontrak_m')
            ->where('kontrak_m.id', '=', $id)
            ->first();
        // End tampilkan untuk edit
        $dt = DB::table('dt')
            ->where('kontrak_m_id', '=', $id)
            ->get();

        // dd($kontrakBox);


        // dd($kontrak_M);
        $count = count($kontrak_D);


        // dd($kontrak_M);
        return view('admin.kontrak.pdf', compact(
            'cust',
            'mc',
            'top',
            'sales',
            'count',
            'kontrak_D',
            'kontrakBox',
            'dt',
        ), ['kontrak_M' => $kontrak_M]);
    }
}
