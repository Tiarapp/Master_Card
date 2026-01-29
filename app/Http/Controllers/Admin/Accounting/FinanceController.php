<?php

namespace App\Http\Controllers\Admin\Accounting;

use App\Http\Controllers\Controller;
use App\Imports\JurnalImport;
use App\Exports\VendorTTExport;
use App\Models\Accounting\Piutang;
use App\Models\Accounting\VendorTTDet;
use App\Models\DeliveryTime;
use App\Models\Number_Sequence;
use App\Models\Opi_M;
use App\Models\PurchaseOrder;
use DateTime;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Yajra\DataTables\DataTables;

use function Ramsey\Uuid\v1;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        // STEP 1: Get piutang data from SQL Server
        $piutang = Piutang::select(
            'KodeCust', 
            'NamaCust', 
            DB::raw("SUM(CASE WHEN Note = 'RETUR' THEN TotalRp * -1 ELSE TotalRp END) as total_piutang"), 
            DB::raw('SUM(TotalTerima) as total_terima')
        )
        ->whereIn('Note', ['JUAL', 'RETUR'])
        ->groupBy('KodeCust', 'NamaCust')
        ->orderBy('KodeCust', 'Asc')
        ->get();

        // STEP 2: Get customer data from Firebird
        $customers = DB::connection('firebird')->table('TCustomer')
            ->select('Kode', 'Nama', 'AlamatKantor', 'KotaKantor', 'Plafond', 'WAKTUBAYAR')
            ->get()
            ->keyBy('Kode'); // Index by Kode for faster lookup

        // STEP 3: Manual join - merge data based on KodeCust = Kode
        $piutangWithCustomer = $piutang->map(function($item) use ($customers) {
            $kodeCust = trim($item->KodeCust); // Clean whitespace
            
            // Find matching customer by Kode
            $customer = $customers->get($kodeCust);
            
            // Add customer data to piutang item
            $item->customer_alamat = $customer->AlamatKantor ?? 'N/A';
            $item->customer_kota = $customer->KotaKantor ?? 'N/A';
            $item->customer_plafond = $customer->Plafond ?? 0;
            $item->customer_waktu_bayar = $customer->WAKTUBAYAR ?? 0;
            $item->customer_found = $customer !== null;
            
            // Calculate sisa piutang
            $item->sisa_piutang = $item->total_piutang - $item->total_terima;
            
            return $item;
        });

        // Send both variables for backward compatibility
        return view('admin.acc.piutang', compact('piutang', 'piutangWithCustomer', 'customers'));
    }

    /**
     * Helper method untuk join data customer dari Firebird dengan data piutang dari SQL Server
     * @param string $kodeCust
     * @return object|null
     */
    private function getCustomerByKode($kodeCust)
    {
        static $customerCache = null;
        
        // Cache customers untuk menghindari query berulang
        if ($customerCache === null) {
            $customerCache = DB::connection('firebird')->table('TCustomer')
                ->select('Kode', 'Nama', 'AlamatKantor', 'KotaKantor', 'Plafond', 'WAKTUBAYAR')
                ->get()
                ->keyBy(function($item) {
                    return trim($item->Kode); // Normalize whitespace
                });
        }
        
        return $customerCache->get(trim($kodeCust));
    }

    /**
     * Enhanced method untuk mendapatkan data piutang customer tertentu dengan relasi cross-database
     */
    public function get_piutang_cust($cust)
    {
        // Get piutang data from SQL Server
        $piutang = Piutang::select(
            'NoBukti',
            'NoRef', 
            'Tanggal',
            'TotalRp',
            'TotalTerima',
            'TglJT',
            'Note',
            DB::raw("CASE 
                WHEN Note = 'RETUR' THEN (TotalRp + TotalTerima)
                ELSE (TotalRp - TotalTerima)
                END as sisa_piutang"),
            DB::raw("DATEDIFF(DAY, TglJT, GETDATE()) as selisih_hari")
        )
        ->where('KodeCust', $cust)
        ->whereIn('Note', ['JUAL', 'RETUR'])
        ->whereRaw("(CASE WHEN Note = 'RETUR' THEN (TotalRp + TotalTerima) ELSE (TotalRp - TotalTerima) END) != 0")
        ->orderBy('Tanggal', 'Asc')
        ->get();

        // Get customer data from Firebird using helper method
        $customer = $this->getCustomerByKode($cust);
        
        if (!$customer) {
            // Fallback jika customer tidak ditemukan
            $customer = (object) [
                'Kode' => $cust,
                'Nama' => 'Customer tidak ditemukan',
                'AlamatKantor' => 'N/A',
                'KotaKantor' => 'N/A',
                'Plafond' => 0,
                'WAKTUBAYAR' => 0
            ];
        }

        // dd($customer);

        // Calculate additional metrics
        $totalPiutang = $piutang->sum('sisa_piutang');
        $sisaLimit = $customer->Plafond - $totalPiutang;
        $piutangOverdue = $piutang->where('selisih_hari', '>', 0);
        
        
        dd($piutang, $customer, $totalPiutang, $sisaLimit, $piutangOverdue);

        return view('admin.acc.piutang_cust', compact('customer', 'piutang', 'totalPiutang', 'sisaLimit', 'piutangOverdue'));
    }

    /**
     * Advanced method: Cross-database join menggunakan Raw SQL (jika memungkinkan)
     * Hanya bisa digunakan jika SQL Server dan Firebird ada di server yang sama
     */
    public function get_piutang_advanced()
    {
        try {
            // Attempt cross-database query (hanya jika konfigurasi mendukung)
            $piutangWithCustomer = DB::select("
                SELECT 
                    p.KodeCust,
                    p.NamaCust,
                    SUM(CASE WHEN p.Note = 'RETUR' THEN p.TotalRp * -1 ELSE p.TotalRp END) as total_piutang,
                    SUM(p.TotalTerima) as total_terima,
                    c.AlamatKantor,
                    c.KotaKantor,
                    c.Plafond,
                    c.WAKTUBAYAR
                FROM Piutang p
                LEFT JOIN OPENQUERY(FIREBIRD_LINKED_SERVER, 
                    'SELECT Kode, Nama, AlamatKantor, KotaKantor, Plafond, WAKTUBAYAR FROM TCustomer'
                ) c ON TRIM(p.KodeCust) = TRIM(c.Kode)
                WHERE p.Note IN ('JUAL', 'RETUR')
                GROUP BY p.KodeCust, p.NamaCust, c.AlamatKantor, c.KotaKantor, c.Plafond, c.WAKTUBAYAR
                ORDER BY p.KodeCust ASC
            ");
            
            return view('admin.acc.piutang_advanced', compact('piutangWithCustomer'));
            
        } catch (\Exception $e) {
            // Fallback to manual join method
            return $this->get_piutang();
        }
    }

    /**
     * Method untuk sinkronisasi data customer secara berkala
     * Bisa dijadwalkan dengan Laravel Scheduler
     */
    public function syncCustomerData()
    {
        try {
            // Get all customers from Firebird
            $customers = DB::connection('firebird')->table('TCustomer')
                ->select('Kode', 'Nama', 'AlamatKantor', 'KotaKantor', 'Plafond', 'WAKTUBAYAR')
                ->get();
            
            // Create/update customer cache table di SQL Server (optional)
            foreach ($customers as $customer) {
                DB::table('customer_cache')->updateOrInsert(
                    ['kode' => trim($customer->Kode)],
                    [
                        'nama' => $customer->Nama,
                        'alamat' => $customer->AlamatKantor,
                        'kota' => $customer->KotaKantor,
                        'plafond' => $customer->Plafond,
                        'waktu_bayar' => $customer->WAKTUBAYAR,
                        'updated_at' => now()
                    ]
                );
            }
            
            return response()->json(['success' => 'Customer data synchronized successfully']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sync failed: ' . $e->getMessage()], 500);
        }
    }    
    
    public function vendor_tt(Request $request)
    {
        try {
            $vendortt = VendorTTDet::with('master_vend');

            // Search filter - pencarian berdasarkan NoTT, BBMNo, InvNumber, PONumber
            if ($request->filled('search')) {
                $search = $request->search;
                $vendortt = $vendortt->where(function($query) use ($search) {
                    $query->where('NoTT', 'LIKE', '%' . $search . '%')
                          ->orWhere('BBMNo', 'LIKE', '%' . $search . '%')
                          ->orWhere('InvNumber', 'LIKE', '%' . $search . '%')
                          ->orWhere('PONumber', 'LIKE', '%' . $search . '%');
                });
            }

            // Date range filter
            if ($request->filled('date_start') && $request->filled('date_end')) {
                $dateStart = $request->date_start;
                $dateEnd = $request->date_end;
                
                // Filter berdasarkan Tglterima dari tabel VendorTT
                $vendortt = $vendortt->whereHas('master_vend', function($query) use ($dateStart, $dateEnd) {
                    $query->whereBetween('Tglterima', [$dateStart, $dateEnd]);
                });
            }           

            // Try ordering by TglTerima from VendorTT using raw SQL
            try {
                $vendortt = $vendortt->orderByRaw('(SELECT Tglterima FROM VendorTT WHERE VendorTT.NoTT = VendTTDet.NoTT) DESC')
                                   ->paginate(20);
            } catch (\Exception $orderException) {
                // Fallback to ordering by NoTT if TglTerima query fails
                $vendortt = $vendortt->orderBy('NoTT', 'desc')->paginate(20);
            }

        } catch (\Exception $e) {
            // If there's any error, return empty collection
            $vendortt = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]), 0, 20, 1, [
                    'path' => request()->url(),
                    'pageName' => 'page',
                ]
            );
        }        return view('admin.acc.vendor_tt', compact('vendortt'));
    }    

    public function update_po(Request $request)
    {

        if ($request->gudang_filter == 'Teknik') {
            DB::connection('fbteknik')->beginTransaction();
           $data = DB::connection('fbteknik')->table('TOPTK')
            ->where('Periode', 'LIKE', $request->periode_manual.'%')
            ->select('NoOP', 'WaktuBayar')
            ->get();
        } elseif ($request->gudang_filter == 'BP') {
            DB::connection('fbbp')->beginTransaction();
            $data = DB::connection('fbbp')->table('TOPConv')
            ->where('Periode', 'LIKE', $request->periode_manual.'%')
            ->select('NoOP', 'WaktuBayar')
            ->get();
        } elseif ($request->gudang_filter == 'Stationary') {
            
            DB::connection('stationary')->beginTransaction();
            $data = DB::connection('stationary')->table('TOPStat')
            ->where('Periode', 'LIKE', $request->periode_manual.'%')
            ->select('NomerOP as NoOP', 'WaktuBayar')
            ->get();
        } else {
            return redirect()->back()->with('error', 'Gudang filter tidak valid.');
        }

        // dd($data);

        foreach ($data as $item) {
            $po = PurchaseOrder::where('po_number', trim($item->NoOP))->first();
            
            if ($po) {
                $po->top = $item->WaktuBayar;
                $po->save();
            } else {
                $new = new PurchaseOrder();
                $new->po_number = trim($item->NoOP);
                $new->top = $item->WaktuBayar;
                $new->save();
            }
        }

        return redirect()->back()->with('success', 'Data PO Teknik berhasil Synchronize.');
    }

    public function approve_opi(Request $request)
    {
        $search = $request->input('search') ? $request->input('search') : '';

        $opi = Opi_M::with('kontrakm');

        if ($search) {
            $opi = $opi->where('NoOPI', 'like', '%' . $search . '%')
                ->orWhereHas('kontrakm', function ($query) use ($search) {
                    $query->where('customer_name', 'like', '%' . $search . '%');
                });
        }

        $opi = $opi->where('status_opi', 'Pending')
                    ->orderBy('created_at', 'asc');  // Ubah dari 'desc' ke 'asc'

        $opi = $opi->paginate(10);

        return view('admin.acc.approve_opi', compact('opi', 'search'));
    }

    public function approve_opi_action(Request $request, $id)
    {
        $opi = Opi_M::findOrFail($id);
        
        if ($opi->status_opi == 'Pending') {
            try {
                $numb_opi = $opi->assign_numb_opi();
                return redirect()->back()->with('success', "OPI berhasil disetujui dengan nomor: {$numb_opi}");
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal approve OPI: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'OPI sudah tidak berstatus Pending.');
        }
    }

    public function approve_opi_bulk(Request $request)
    {
        // Debug: Log the incoming request data
        Log::info('Bulk Approve Request Data:', $request->all());
        
        $request->validate([
            'selected_opi' => 'required|array|min:1',
            'selected_opi.*' => 'exists:opi_m,id'
        ]);

        $selectedIds = $request->input('selected_opi');
        $approvedCount = 0;
        $approvedNumbers = [];

        foreach ($selectedIds as $id) {
            $opi = Opi_M::find($id);
            if ($opi && $opi->status_opi == 'Pending') {
                try {
                    // Menggunakan method baru dari model
                    $numb_opi = $opi->assign_numb_opi();
                    
                    $approvedCount++;
                    $approvedNumbers[] = $numb_opi;
                } catch (\Exception $e) {
                    Log::error('Error approving OPI ID ' . $id . ': ' . $e->getMessage());
                    continue;
                }
            }
        }

        if ($approvedCount > 0) {
            $message = "Berhasil approve {$approvedCount} OPI: " . implode(', ', $approvedNumbers);
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Tidak ada OPI yang berhasil di-approve.');
        }
    }
}
