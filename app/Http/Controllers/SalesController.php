<?php

namespace App\Http\Controllers;

use App\Exports\SalesCustomerExport;
use App\Models\Sales;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = DB::table('sales_m')
            // ->where('deleted', '=', '0')
            ->get();

            return view('admin.sales.index', compact('sales'));
    }

    public function exportCustomer()
    {
        $data = DB::table('kontrak_m as k')
            ->leftJoin('sales_m as s', DB::raw('TRIM(s.nama)'), '=', DB::raw('TRIM(k.sales)'))
            ->whereNull('k.deletedAt')
            ->whereNotNull('k.sales')
            ->where('k.sales', '!=', '')
            ->groupBy('k.sales', 'k.customer_name', 's.aktif')
            ->orderBy('k.sales')
            ->orderBy('k.customer_name')
            ->select(
                DB::raw('TRIM(k.sales) as sales_nama'),
                DB::raw("CASE s.aktif WHEN 1 THEN 'Aktif' WHEN 2 THEN 'Non Aktif' ELSE 'Tidak ada di master sales' END as sales_status"),
                'k.customer_name as customer_nama',
                DB::raw('COUNT(*) as jumlah_kontrak'),
                DB::raw('MIN(k.tglKontrak) as kontrak_pertama'),
                DB::raw('MAX(k.tglKontrak) as kontrak_terakhir')
            )
            ->get();

        return Excel::download(
            new SalesCustomerExport($data),
            'sales_customer_' . date('Ymd_His') . '.xlsx'
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alias' => 'required',
            // 'hp' => 'required | numeric',
            'komisi' => 'required | numeric',
            'createdBy' => 'required',
            'branch' => 'required'
        ]);

        Sales::create($request->all());

        return redirect('/admin/sales');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sales::find($id);

        return view('admin.sales.show', ['sales' => $sales]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales = Sales::find($id);

        return view('admin.sales.edit', ['sales' => $sales]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alias' => 'required',
            // 'hp' => 'required|numeric',
            'komisi' => 'required|numeric',
            'lastUpdatedBy' => 'required',
            'branch' => 'required'
        ]);

        $sales = Sales::find($id);

        $sales->nama = $request->nama;
        $sales->alias = $request->alias;
        $sales->hp = $request->hp;
        $sales->komisi = $request->komisi;
        $sales->branch = $request->branch;
        $sales->lastUpdatedBy = $request->lastUpdatedBy;

        $sales->save();
            // dd($sales->save());
        return redirect('/admin/sales');
    }

    public function updateDeleted($id)
    {
        $sales = Sales::find($id);

        $sales->deleted = 1;
        $sales->deletedAt = date('Y-m-d h:i:s');
        $sales->lastUpdatedBy = Auth::user()->name;
        $sales->deletedBy = Auth::user()->name;

        $sales->save();

        return redirect('/admin/satuans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
