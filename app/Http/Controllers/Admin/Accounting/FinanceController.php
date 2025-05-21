<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Imports\JurnalImport;
use App\Models\Accounting\Piutang;
use DateTime;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Yajra\DataTables\DataTables;

class FinanceController extends Controller
{
    public function index()
    {
        return view('admin.acc.import_ju');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $import = new JurnalImport();

        Excel::import($import, $file);

        return back()->with('success', 'File imported successfully!');
    }

    public function index_faktur(Request $request)
    {
        return view('admin.acc.data_faktur');
    }

    public function get_faktur(Request $request)
    {
        DB::connection('firebird2')->beginTransaction();

        
        if ($request->periode !== '') {
            $faktur = DB::connection('firebird2')->table('TFakturConv')
            ->leftJoin('TSuratJalan as a', 'a.NomerSJ', '=', 'TFakturConv.NomerSJ')
            ->where('TFakturConv.Periode', 'LIKE', $request->periode.'%')
            ->select('NoFaktur', 'TFakturConv.NoFakturPajak', 'NoKwitansi', 'TFakturConv.NomerSJ', 'a.TglSJ', 'a.NamaCust', 'TotalTagihan')
            ->get();
            
            return DataTables::of($faktur)
                ->addColumn('action', function($faktur) {
                    return "<button><a href='../finance/faktur/print/" .trim($faktur->NomerSJ). "' title='SHOW' ><span class='glyphicon glyphicon-list'>Print</span></a></button>";
                })
                ->addColumn('total', function($faktur){ 
                    return number_format(round($faktur->TotalTagihan, 2), 2, ',', '.');
                })
                ->make(true);
        }
        
    }

    public function terbilang($angka)
    {
        $angka = abs($angka);
            $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
            $temp = "";
        
            if ($angka < 12) {
                $temp = " " . $huruf[$angka];
            } elseif ($angka < 20) {
                $temp = terbilang($angka - 10) . " belas";
            } elseif ($angka < 100) {
                $temp = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
            } elseif ($angka < 200) {
                $temp = "seratus" . terbilang($angka - 100);
            } elseif ($angka < 1000) {
                $temp = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
            } elseif ($angka < 2000) {
                $temp = "seribu" . terbilang($angka - 1000);
            } elseif ($angka < 1000000) {
                $temp = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
            } elseif ($angka < 1000000000) {
                $temp = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
            } elseif ($angka < 1000000000000) {
                $temp = terbilang($angka / 1000000000) . " miliar" . terbilang($angka % 1000000000);
            } elseif ($angka < 1000000000000000) {
                $temp = terbilang($angka / 1000000000000) . " triliun" . terbilang($angka % 1000000000000);
            }
        
            return trim($temp);
    }

    public function print_faktur($kode)
    {
        DB::connection('firebird2')->beginTransaction();

        $faktur = DB::connection('firebird2')->table('TFakturConv')
            ->leftJoin('TSuratJalan as a', 'a.NomerSJ', '=', 'TFakturConv.NomerSJ')
            ->leftJoin('TDetSJ as b', 'a.NomerSJ', '=', 'b.NomerSJ')
            ->leftJoin('TBarangConv as c', 'b.KodeBrg', '=', 'c.KodeBrg' )
            ->where('TFakturConv.NomerSJ', 'LIKE', $kode.'%')
            ->select('NoFaktur', 'TFakturConv.NoFakturPajak', 'NoKwitansi', 'TFakturConv.NomerSJ', 'a.TglSJ', 'a.NamaCust', 'TotalTagihan', 'b.KodeBrg', 'c.NamaBrg', 'a.KodeCust', 'TFakturConv.WaktuBayar', 'TFakturConv.TglFaktur', 'b.Quantity', 'b.HargaAwal', 'TFakturConv.TotalAwal', 'TFakturConv.PPH22')
            ->first();

        $cust = DB::connection('firebird')->table('TCustomer')
                ->where('Kode', 'LIKE', '%'.trim($faktur->KodeCust).'%')
                ->select('KotaKantor', 'AlamatKantor')
                ->first();
            
            function terbilang($angka)
            {
                $angka = abs($angka);
                $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
                $temp = "";
            
                if ($angka < 12) {
                    $temp = " " . $huruf[$angka];
                } elseif ($angka < 20) {
                    $temp = terbilang($angka - 10) . " belas ";
                } elseif ($angka < 100) {
                    $temp = terbilang($angka / 10) . " puluh " . terbilang($angka % 10);
                } elseif ($angka < 200) {
                    $temp = "seratus" . terbilang($angka - 100);
                } elseif ($angka < 1000) {
                    $temp = terbilang($angka / 100) . " ratus " . terbilang($angka % 100);
                } elseif ($angka < 2000) {
                    $temp = "seribu" . terbilang($angka - 1000);
                } elseif ($angka < 1000000) {
                    $temp = terbilang($angka / 1000) . " ribu " . terbilang($angka % 1000);
                } elseif ($angka < 1000000000) {
                    $temp = terbilang($angka / 1000000) . " juta " . terbilang($angka % 1000000);
                } elseif ($angka < 1000000000000) {
                    $temp = terbilang($angka / 1000000000) . " miliar " . terbilang($angka % 1000000000);
                } elseif ($angka < 1000000000000000) {
                    $temp = terbilang($angka / 1000000000000) . " triliun " . terbilang($angka % 1000000000000);
                }
            
                return trim($temp);
            }

            $angka = explode('.', round($faktur->TotalTagihan,2));

            if (count($angka) > 1) {
                if ($angka[1] > 0) {
                    $terbilang = terbilang($angka[0]). " dan " . terbilang($angka[1]);
                } else {
                    $terbilang = terbilang($angka[0]);
                }
            } else {
                $terbilang = terbilang($angka[0]);
            }

            $top = new DateTime($faktur->TglSJ);
            $top->modify('+'.$faktur->WaktuBayar.' days');

            // dd($faktur, $cust, $top, $angka);
        

        return view('admin.acc.print_faktur', compact('terbilang', 'faktur', 'cust', 'top'));
    }

    public function getCust()
    {
        DB::connection('firebird')->beginTransaction();
        $cust = DB::connection('firebird')->table('TCustomer')->get();

        return view('admin.acc.data_cust', compact('cust'));
    }

    public function get_piutang()
    {
        $piutang = Piutang::select(
            'KodeCust', 
            'NamaCust', 
            // 'Note', 
            DB::raw("SUM(CASE WHEN Note = 'RETUR' THEN TotalRp * -1 ELSE TotalRp END) as total_piutang"), 
            DB::raw('SUM(TotalTerima) as total_terima')
            )
            ->whereIn('Note', ['JUAL', 'RETUR']) // Ensure only valid values are queried
            // ->where('TotalTerima', 0)
            ->groupBy('KodeCust', 'NamaCust')
            ->orderBy('KodeCust', 'Asc')
            ->get();

        return view('admin.acc.piutang', compact('piutang'));
    }

    // public function piutang()
    // {
    //     return view('admin.acc.piutang');
    // }

    public function get_piutang_cust($cust)
    {
        $piutang = Piutang::select(
            'KodeCust', 
            // 'NamaCust', 
            // 'Note', 
            DB::raw("SUM(CASE WHEN Note = 'RETUR' THEN TotalRp * -1 ELSE TotalRp END) as total_piutang"), 
            DB::raw('SUM(TotalTerima) as total_terima')
            )
            ->whereIn('Note', ['JUAL', 'RETUR']) // Ensure only valid values are queried
            ->where('KodeCust', $cust)
            ->groupBy('KodeCust')
            ->orderBy('KodeCust', 'Asc')
            ->get();

        return response()->json($piutang);
    }
}
