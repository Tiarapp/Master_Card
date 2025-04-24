<?php

namespace App\Http\Controllers\Admin\HRD;

use App\Http\Controllers\Controller;
use App\Models\HRD\Stationary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StationaryController extends Controller
{
    public function getBarang(Request $request)
    {
        DB::connection('stationary')->beginTransaction();
        if ($request->ajax()) {
            $stationary = Stationary::barang()->get();
            return DataTables::of($stationary)
                ->addColumn('saldo_akhir_p', function($stationary) {
                    return number_format($stationary->SaldoAkhirP, 2);
                })
                ->addColumn('saldo_akhir_s', function($stationary) {
                    return number_format($stationary->SaldoAkhirS, 2);
                })
                ->make(true);
        }

        return view('admin.hrd.stationary.barang');
    }
}
