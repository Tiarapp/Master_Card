<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Faker\Core\Number;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MarektingOrder extends Controller
{
    public function get_mod_by_tanggal()
    {
        return view('admin.Marketing.mod.mod');
    }

    public function getMod($tanggal)
    {
        DB::connection('firebird2')->beginTransaction();

        $mod = DB::connection('firebird2')->table('TDetMOD')
            ->leftJoin('TMOD', 'TDetMOD.NoMOD', '=', 'TMOD.NoBukti')
            ->leftJoin('TBarangConv', 'TDetMOD.KodeBrg', '=', 'TBarangConv.KodeBrg')
            ->select('TDetMOD.*', 'TMOD.TglOrder', 'TMOD.NamaCust', 'TMOD.NomerSC', 'TBarangConv.NamaBrg')
            ->where('TMOD.TglOrder', 'LIKE', $tanggal)
            ->get();

       return DataTables::of($mod)->toJson();
    }

    public function index(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();
        if ($request->ajax()) {
            $mod = DB::connection('firebird2')->table('TMOD')
            ->get();

            return DataTables::of($mod)
                ->addColumn('action', function($mod){
                    return '<a href="../marketing/mod/edit/'. $mod->NoBukti .'" class="btn btn-outline-success" type="button">
                                <i class="fa fa-eye" data-toggle="tooltip" data-placement="bottom" title="view" id="view"></i>
                            </a>';
                })
                ->addColumn('qtyCrt', function($mod){
                    $qty = intval($mod->TotQtyCrt);
                    return number_format($qty, 2);
                })
                ->addColumn('qtyEcr', function($mod){
                    $qty = intval($mod->TotQtyEcr);
                    return number_format($qty, 2);
                })
                ->addColumn('total', function($mod){
                    $qty = intval($mod->TotalAkhir);
                    return number_format($qty, 2);
                })
                ->make(true);
        }
        return view('admin.Marketing.mod.index');
    }

    public function get_mata_uang($kode)
    {
        DB::connection('firebird')->beginTransaction();

        if ($kode) {
            $matauang = DB::connection('firebird')->table('TMataUang')
                    ->where('MataUang', 'LIKE', $kode.'%')
                    ->first();
            
            $matauang2 = DB::connection('firebird')->table('TMataUang')
            ->where('MataUang', 'LIKE', 'USD%')
            ->first();

            $nilai = number_format($matauang->Nilai,2,'.','');
            $usd = number_format($matauang2->Nilai,2,'.','');
        }

        $data = [
            'nilai' => $nilai,
            'usd' => $usd
        ];

        return response()->json($data);
    }

    public function get_kode_mod($tujuan)
    {
        DB::connection('firebird2')->beginTransaction();
        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        $concat = $year . $month;

        if ($tujuan == 'LOKAL') {
            $kode = "ML-2".$concat;

            $key = DB::connection('firebird2')->table('TKeyfield')
                        ->where('Nama', 'LIKE', $kode."%")->first();
            if ($key) {
                $nurut = str_pad($key->NoUrut + 1, 3, '0', STR_PAD_LEFT);
            } else {
                DB::connection('firebird2')->table('TKeyfield')->insert([
                    'Nama' => $kode,
                    'NoUrut' => 0
                ]);
                
                 DB::connection('firebird2')->commit();
                $nurut = str_pad(1, 3, '0', STR_PAD_LEFT);
            }
        }

        $no_bukti = $kode . $nurut;
        $data = [
            'kode' => $no_bukti
        ];
        
        return response()->json($data);
    }

    public function create()
    {
        $date = Carbon::now()->format('Y-m-d');
        $cust = DB::connection('firebird')->table('TCustomer')->get();
        $uang = DB::connection('firebird')->table('TMataUang')->get();
        return view('admin.Marketing.mod.create', compact('date','cust','uang'));
    }

    public function save_master(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();
        
        $periode = Carbon::now()->format('m/Y');
        $concat = substr($request->kode, 0, 8);

        $data = DB::connection('firebird2')->table('TMOD')->insert([
            'NoBukti' => $request->kode,
            'Periode' => $periode,
            'Tujuan' => $request->tujuan,
            'TglOrder' => $request->tanggal,
            'TglKirim' => $request->tanggal_kirim,
            'KodeCustomer' => $request->KodeCust,
            'NamaCust' => $request->NamaCust,
            'NomerSC' => $request->nokontrak,
            'NomerPI_PO' => $request->nopo,
            'KirimKe' => $request->AlamatKirim,
            'AlmtKantor' => $request->AlamatKantor,
            'JenisOrder' => $request->order,
            'StatusHarga' => $request->pajak,
            'WaktuBayar' => $request->top,
            'MataUang' => $request->matauang,
            'NilaiKursRp' => $request->kurs_rp,
            'NilaiKursUSD' => (int) $request->kurs_usd,
            'Aktif' => 'N',
            'Print' => 0
        ]);

        $key = DB::connection('firebird2')->table('TKeyfield')
            ->where('Nama', 'LIKE', $concat.'%')->first();

        DB::connection('firebird2')->table('TKeyfield')
            ->where('Nama', 'LIKE', $concat.'%')
            ->update([
                'NoUrut' => $key->NoUrut + 1
            ]);

        DB::connection('firebird2')->commit();

        return response()->json([
            'success' => true,
            'data' => $data,
            'kode' => $request->kode
        ]);
    }

    public function get_detail($kode)
    {
        DB::connection('firebird2')->beginTransaction();

        $detail = DB::connection('firebird2')->table('TDetMOD')
                ->leftJoin('TBarangConv', 'TDetMOD.KodeBrg', '=', 'TBarangConv.KodeBrg')
                ->where('NoMOD', 'LIKE', $kode.'%')
                ->select('TDetMOD.KodeBrg as kode_barang', 'TBarangConv.NamaBrg', 'Quantity', 'HargaAwal', 'SubTotalAwal')
                ->get();
        $master = DB::connection('firebird2')->table('TMOD')->where('NoBukti', 'LIKE', $kode.'%')
                ->select('TotalAwal', 'PPN', 'TotalAkhir')
                ->first();

        $data = [
            "detail" => $detail,
            "master" => $master
        ];
        
        return response()->json($data);
    }

    public function save_detail(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();
        $nurut = DB::connection('firebird2')->table('TDetMOD')->orderBy('NoUrut', 'desc')->first();

        $master = DB::connection('firebird2')->table('TMOD')->where('NoBukti', 'LIKE', $request->nomod.'%')->first();
        
        DB::connection('firebird2')->table('TMOD')->where('NoBukti', 'LIKE', $request->nomod.'%')
            ->update([
                'TotQtyCrt' => 0,
                'TotQtyEcr' => $master->TotQtyEcr + $request->qty,
                'TotalAwal' => $master->TotalAwal + $request->total_awal,
                'Potongan' => 0,
                'SebelumPPN' => $master->SebelumPPN + $request->total_awal,
                'PPN' => $master->PPN + $request->ppn,
                'TotalAkhir' => $master->TotalAkhir + $request->total_akhir,
            ]);

        $data = DB::connection('firebird2')->table('TDetMOD')->insert([
            'NoUrut' => $nurut->NoUrut+1,
            'NoMOD' => $request->nomod,
            'KodeBrg' => $request->kode_barang,
            'Quantity' => $request->qty,
            'HargaAwal' => $request->harga,
            'Discount1' => 0,
            'Discount2' => 0,
            'Discount3' => 0,
            'Discount4' => 0,
            'Discount5' => 0,
            'QtyTerkirim' => 0,
            'OutstandKirim' => $request->qty,
            'SubTotalAwal' => $request->total_awal,
            'SubTotalDisc' => 0,
            'SubTotalSblmPPN' => $request->total_awal,
            'PPN' => $request->ppn,
            'SubTotalAkhir' => $request->total_akhir,
            'PPH22' => 0,
            'BCDate' => $request->bc_date
        ]);

        DB::connection('firebird2')->commit();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }   
}
