<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use App\Exports\DeadstockExport;

class ReportController extends Controller
{
    // public function deadstock(Request $request)
    // {
    //     $periode = $request->periode ?? '09/2025';
        
    //     try {
    //         \Illuminate\Support\Facades\Log::info("Starting new deadstock method for periode: {$periode}");
            
    //         DB::connection('firebird2')->beginTransaction();
            
    //         $stockData = DB::connection('firebird2')->select('
    //             SELECT FIRST 50
    //                 "KodeBrg",
    //                 "SaldoAkhirCrt", 
    //                 "SaldoAkhirKg",
    //                 "Periode"
    //             FROM "TPersediaan"
    //             WHERE "Periode" LIKE ?
    //                 AND ("SaldoAkhirCrt" > 0 OR "SaldoAkhirKg" > 0)
    //             ORDER BY "SaldoAkhirCrt" DESC
    //         ', ['%'.$periode.'%']);
            
    //         DB::connection('firebird2')->commit();
            
    //         $stock = collect($stockData);
    //         $totalItems = $stock->count();
    //         $totalCrt = $stock->sum('SaldoAkhirCrt');
    //         $totalKg = $stock->sum('SaldoAkhirKg');
            
    //         \Illuminate\Support\Facades\Log::info("Successfully loaded {$totalItems} items, Total Crt: {$totalCrt}");
            
    //         $deadstockCategories = collect([
    //             'High Stock (>1000 Crt)' => $stock->filter(fn($item) => ($item->SaldoAkhirCrt ?? 0) > 1000),
    //             'Medium Stock (100-1000 Crt)' => $stock->filter(fn($item) => ($item->SaldoAkhirCrt ?? 0) >= 100 && ($item->SaldoAkhirCrt ?? 0) <= 1000),
    //             'Low Stock (<100 Crt)' => $stock->filter(fn($item) => ($item->SaldoAkhirCrt ?? 0) < 100 && ($item->SaldoAkhirCrt ?? 0) > 0)
    //         ]);
            
    //         $stockWithSJ = $stock->take(intval($stock->count() * 0.7));
    //         $stockWithoutSJ = $stock->skip(intval($stock->count() * 0.7));
    //         $avgDeadstockDays = 45;
            
    //     } catch (\Exception $e) {
    //         \Illuminate\Support\Facades\Log::error('New Deadstock Error: ' . $e->getMessage());
            
    //         $stock = collect();
    //         $totalItems = $totalCrt = $totalKg = 0;
    //         $deadstockCategories = collect();
    //         $stockWithSJ = $stockWithoutSJ = collect();
    //         $avgDeadstockDays = 0;
            
    //         return view('admin.reports.deadstock', compact('stock', 'periode', 'totalItems', 'totalCrt', 'totalKg', 'deadstockCategories', 'stockWithSJ', 'stockWithoutSJ', 'avgDeadstockDays'))->with('error', 'Error: ' . $e->getMessage());
    //     }
        
    //     return view('admin.reports.deadstock', compact('stock', 'periode', 'totalItems', 'totalCrt', 'totalKg', 'deadstockCategories', 'stockWithSJ', 'stockWithoutSJ', 'avgDeadstockDays'));
    // }

    // public function deadstock_old(Request $request)
    // {
    //     // Initialize with safe defaults
    //     $stock = collect();
    //     $totalItems = 0;
    //     $totalCrt = 0;
    //     $totalKg = 0;
    //     $deadstockCategories = collect();
    //     $stockWithSJ = collect();
    //     $stockWithoutSJ = collect();
    //     $avgDeadstockDays = 0;
    //     $periode = $request->periode ?? '09/2025';
        
    //     try {
    //         DB::connection('firebird2')->beginTransaction();
            
    //         // Debug: Cek data TPersediaan dulu dengan syntax Firebird yang benar
    //         $testResult = DB::connection('firebird2')
    //             ->select('SELECT COUNT(*) as total FROM "TPersediaan" WHERE "Periode" LIKE ?', ['%'.$periode.'%']);
    //         $testPersediaan = $testResult[0]->TOTAL ?? 0;
            
    //         \Illuminate\Support\Facades\Log::info("Debug Deadstock - TPersediaan count for periode {$periode}: {$testPersediaan}");
            
    //         // Jika tidak ada data untuk periode tersebut, coba tanpa filter periode
    //         if ($testPersediaan == 0) {
    //             $allPeriodes = collect(DB::connection('firebird2')
    //                 ->select('SELECT DISTINCT "Periode" FROM "TPersediaan" ORDER BY "Periode" DESC ROWS 10'));
                
    //             \Illuminate\Support\Facades\Log::info("Available periodes: " . json_encode($allPeriodes));
                
    //             // Gunakan periode terbaru jika tidak ditemukan
    //             if ($allPeriodes->count() > 0) {
    //                 $periode = trim($allPeriodes->first()->Periode ?? '09/2025');
    //             }
    //         }
            
    //         // Query dengan nama table dan kolom yang benar untuk Firebird
    //         $stock = DB::connection('firebird2')
    //             ->select('
    //                 SELECT FIRST 100
    //                     "KodeBrg",
    //                     "SaldoAkhirCrt", 
    //                     "SaldoAkhirKg",
    //                     "Periode"
    //                 FROM "TPersediaan"
    //                 WHERE "Periode" LIKE ?
    //                     AND ("SaldoAkhirCrt" > 0 OR "SaldoAkhirKg" > 0)
    //                 ORDER BY "SaldoAkhirCrt" DESC
    //             ', ['%'.$periode.'%']);
            
    //         $stock = collect($stock);
            
    //         \Illuminate\Support\Facades\Log::info("Stock query result count: " . $stock->count());
            
    //         // Jika masih kosong, coba tanpa filter stock > 0
    //         if ($stock->count() == 0) {
    //             $stock = collect(DB::connection('firebird2')
    //                 ->select('
    //                     SELECT FIRST 50
    //                         "KodeBrg",
    //                         "SaldoAkhirCrt", 
    //                         "SaldoAkhirKg",
    //                         "Periode"
    //                     FROM "TPersediaan"
    //                     WHERE "Periode" LIKE ?
    //                 ', ['%'.$periode.'%']));
                
    //             \Illuminate\Support\Facades\Log::info("Stock without filter count: " . $stock->count());
    //         }
            
    //         DB::connection('firebird2')->commit();
            
    //         // Hitung statistik
    //         $totalItems = $stock->count();
    //         $totalCrt = $stock->sum('SaldoAkhirCrt');
    //         $totalKg = $stock->sum('SaldoAkhirKg');
            
    //         // Kategorisasi sederhana berdasarkan TglKeluar dari TBarangConv
    //         $deadstockCategories = $stock->groupBy(function($item) {
    //             if (!$item->TglKeluar) {
    //                 return 'Tidak Ada Tanggal Keluar';
    //             }
                
    //             try {
    //                 $tglKeluar = \Carbon\Carbon::parse($item->TglKeluar);
    //                 $now = \Carbon\Carbon::now();
    //                 $daysDiff = $tglKeluar->diffInDays($now);
                    
    //                 if ($daysDiff > 365) return 'Deadstock Kritis (>1 tahun)';
    //                 if ($daysDiff > 180) return 'Deadstock Tinggi (6-12 bulan)';
    //                 if ($daysDiff > 90) return 'Deadstock Sedang (3-6 bulan)';
    //                 if ($daysDiff > 30) return 'Slow Moving (1-3 bulan)';
    //                 return 'Fast Moving (<1 bulan)';
    //             } catch (\Exception $e) {
    //                 return 'Tanggal Invalid';
    //             }
    //         });
            
    //         // Statistik sederhana
    //         $stockWithSJ = $stock->filter(function($item) {
    //             return $item->TglKeluar !== null;
    //         });
            
    //         $stockWithoutSJ = $stock->filter(function($item) {
    //             return $item->TglKeluar === null;
    //         });
            
    //         // Rata-rata hari berdasarkan TglKeluar
    //         $avgDeadstockDays = 0;
    //         if ($stockWithSJ->count() > 0) {
    //             $totalDays = 0;
    //             $validCount = 0;
                
    //             foreach ($stockWithSJ as $item) {
    //                 try {
    //                     if ($item->TglKeluar) {
    //                         $days = \Carbon\Carbon::parse($item->TglKeluar)->diffInDays(\Carbon\Carbon::now());
    //                         $totalDays += $days;
    //                         $validCount++;
    //                     }
    //                 } catch (\Exception $e) {
    //                     continue;
    //                 }
    //             }
                
    //             if ($validCount > 0) {
    //                 $avgDeadstockDays = $totalDays / $validCount;
    //             }
    //         }
            
    //         return view('admin.reports.deadstock', compact(
    //             'stock', 
    //             'periode', 
    //             'totalItems', 
    //             'totalCrt', 
    //             'totalKg',
    //             'deadstockCategories',
    //             'stockWithSJ',
    //             'stockWithoutSJ',
    //             'avgDeadstockDays'
    //         ));
            
    //     } catch (\Exception $e) {
    //         if (DB::connection('firebird2')->transactionLevel() > 0) {
    //             DB::connection('firebird2')->rollback();
    //         }
            
    //         // Log the error with more detail
    //         \Illuminate\Support\Facades\Log::error('Deadstock Report Error: ' . $e->getMessage());
    //         \Illuminate\Support\Facades\Log::error('Stack trace: ' . $e->getTraceAsString());
            
    //         // Create sample data for testing view
    //         $sampleData = collect([
    //             (object)[
    //                 'KodeBrg' => 'SAMPLE001',
    //                 'NamaBrg' => 'Sample Product 1',
    //                 'SaldoAkhirCrt' => 100,
    //                 'SaldoAkhirKg' => 50.5,
    //                 'TglKeluar' => '2024-01-01',
    //                 'Periode' => $periode
    //             ],
    //             (object)[
    //                 'KodeBrg' => 'SAMPLE002', 
    //                 'NamaBrg' => 'Sample Product 2',
    //                 'SaldoAkhirCrt' => 200,
    //                 'SaldoAkhirKg' => 75.25,
    //                 'TglKeluar' => null,
    //                 'Periode' => $periode
    //             ]
    //         ]);
            
    //         $stock = $sampleData;
    //         $totalItems = $stock->count();
    //         $totalCrt = $stock->sum('SaldoAkhirCrt');
    //         $totalKg = $stock->sum('SaldoAkhirKg');
            
    //         $deadstockCategories = collect([
    //             'Test Category' => $stock
    //         ]);
            
    //         $stockWithSJ = $stock->filter(function($item) {
    //             return $item->TglKeluar !== null;
    //         });
            
    //         $stockWithoutSJ = $stock->filter(function($item) {
    //             return $item->TglKeluar === null;
    //         });
            
    //         $avgDeadstockDays = 30;
            
    //         // Return view with sample data and error message
    //         return view('admin.reports.deadstock', compact(
    //             'stock', 
    //             'periode', 
    //             'totalItems', 
    //             'totalCrt', 
    //             'totalKg',
    //             'deadstockCategories',
    //             'stockWithSJ',
    //             'stockWithoutSJ',
    //             'avgDeadstockDays'
    //         ))->with('error', 'Database connection error. Showing sample data. Error: ' . $e->getMessage());
    //     }
    // }

    public function deadstock(Request $request)
    {
        try {
            $periode = $request->periode ?? date_format(now(), 'm/Y');
            $ageFilter = $request->age_filter ?? null;
            $perPage = $request->per_page ?? 50; // Pagination size
            $page = $request->page ?? 1;
            $offset = ($page - 1) * $perPage;
            
            $startTime = microtime(true);
            \Illuminate\Support\Facades\Log::info("Starting optimized deadstock report for periode: {$periode}");
            
            DB::connection('firebird2')->beginTransaction();
            
            // OPTIMIZED: Cache SJ data terlebih dahulu dengan subquery yang efisien
            $cacheKey = "latest_sj_data_{$periode}_v2";
            $latestSJData = \Illuminate\Support\Facades\Cache::remember($cacheKey, 5, function() use ($periode) {
                try {
                    // Test different approaches to get KodeBrg correctly
                    $testQuery = DB::connection('firebird2')->select('
                        SELECT FIRST 5
                            d."KodeBrg",
                            TRIM(d."KodeBrg") as KodeBrg_Trimmed,
                            CHAR_LENGTH(d."KodeBrg") as KodeBrg_Length,
                            CHAR_LENGTH(TRIM(d."KodeBrg")) as KodeBrg_Trimmed_Length
                        FROM "TDetSJ" d
                        WHERE d."KodeBrg" IS NOT NULL
                    ');
                    
                    \Illuminate\Support\Facades\Log::info("Debug KodeBrg formats: " . json_encode($testQuery));
                    
                    return DB::connection('firebird2')->select('
                        SELECT 
                            d."KodeBrg" as KodeBrg,
                            MAX(s."TglPHP") as LatestTglPHP
                        FROM "TDetPHP" d
                        LEFT JOIN "TPHP" s ON d."NoPHP" = s."NoBukti"
                        WHERE d."KodeBrg" IS NOT NULL 
                            AND TRIM(d."KodeBrg") != \'\'
                            AND CHAR_LENGTH(TRIM(d."KodeBrg")) > 0
                        GROUP BY d."KodeBrg"
                    ');
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Failed to load SJ data: ' . $e->getMessage());
                    return [];
                }
            });

            // dd($latestSJData);
            
            // Convert to keyed collection for O(1) lookup
            $sjLookup = collect($latestSJData)->mapWithKeys(function($item) {
                $trimmedKey = trim($item->KODEBRG ?? '');
                return [$trimmedKey => $item];
            })->filter(function($item, $key) {
                return !empty($key); // Remove empty keys
            });
            // dd($sjLookup);

            // DEBUG: Log detailed info about SJ data
            \Illuminate\Support\Facades\Log::info("Raw SJ data count: " . count($latestSJData));
            \Illuminate\Support\Facades\Log::info("SJ Lookup count after keyBy: " . $sjLookup->count());
            
            if (count($latestSJData) > 0) {
                \Illuminate\Support\Facades\Log::info("First 3 raw SJ items: " . json_encode(array_slice($latestSJData, 0, 3)));
            }
            
            // Check if there are duplicates causing keyBy to overwrite
            $kodeBarangCounts = collect($latestSJData)->countBy(function($item) {
                return trim($item->KODEBRG ?? '');
            });
            $duplicates = $kodeBarangCounts->filter(function($count) { return $count > 1; });
            \Illuminate\Support\Facades\Log::info("Duplicate KodeBrg count: " . $duplicates->count());
            if ($duplicates->count() > 0) {
                \Illuminate\Support\Facades\Log::info("Sample duplicates: " . json_encode($duplicates->take(5)->toArray()));
            }
            
            // OPTIMIZED: Get ALL persediaan data first (for filtering)
            $persediaan = DB::connection('firebird2')->select('
                SELECT 
                    p."KodeBrg",
                    b."NamaBrg",
                    p."SaldoAkhirCrt", 
                    p."SaldoAkhirKg",
                    p."Periode"
                FROM "TPersediaan" p
                LEFT JOIN "TBarangConv" b ON p."KodeBrg" = b."KodeBrg"
                WHERE p."Periode" LIKE ?
                    AND (p."SaldoAkhirCrt" > 0 OR p."SaldoAkhirKg" > 0)
                ORDER BY p."SaldoAkhirCrt" DESC
            ', ['%' . $periode . '%']);
            
            // Get total count BEFORE filtering
            $totalItemsBeforeFilter = count($persediaan);
            
            DB::connection('firebird2')->commit();
            
            $loadTime = round((microtime(true) - $startTime) * 1000, 2);
            \Illuminate\Support\Facades\Log::info("Data loaded in {$loadTime}ms, processing {$totalItemsBeforeFilter} total items");

            // DEBUG: Cek struktur data SJ
            \Illuminate\Support\Facades\Log::info("SJ Lookup count: " . $sjLookup->count());
            if ($sjLookup->count() > 0) {
                $sampleSJ = $sjLookup->first();
                \Illuminate\Support\Facades\Log::info("Sample SJ structure: " . json_encode($sampleSJ));
            }
            
            // OPTIMIZED: Build data with fast lookup
            $stock = collect($persediaan)->map(function($item) use ($sjLookup, $periode) {
                $kodeBarang = trim($item->KodeBrg ?? '');
                $latestSJ = $sjLookup->get($kodeBarang);
                
                // Calculate days since last SJ
                $daysSinceLastSJ = null;
                $tglKeluar = null;
                
                if ($latestSJ && !empty($latestSJ->LATESTTGLPHP)) {
                    $tglKeluar = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->toDateString();
                    
                    // Smart date calculation based on period
                    $currentPeriod = date('m/Y');
                    if ($currentPeriod === $periode) {
                        // Current period - use today
                        $endDate = \Carbon\Carbon::now();
                    } else {
                        // Different period - use last day of that period
                        $periodeParts = explode('/', $periode);
                        if (count($periodeParts) == 2) {
                            $month = (int)$periodeParts[0];
                            $year = (int)$periodeParts[1];
                            $endDate = \Carbon\Carbon::create($year, $month)->endOfMonth();
                        } else {
                            $endDate = \Carbon\Carbon::now();
                        }
                    }
                    
                    $daysSinceLastSJ = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->diffInDays($endDate);
                } else {
                    // No SJ data available - use default date 31/05/2025
                    $tglKeluar = '2025-05-31';
                    
                    // Calculate days from default date to end of period
                    $currentPeriod = date('m/Y');
                    if ($currentPeriod === $periode) {
                        $endDate = \Carbon\Carbon::now();
                    } else {
                        $periodeParts = explode('/', $periode);
                        if (count($periodeParts) == 2) {
                            $month = (int)$periodeParts[0];
                            $year = (int)$periodeParts[1];
                            $endDate = \Carbon\Carbon::create($year, $month)->endOfMonth();
                        } else {
                            $endDate = \Carbon\Carbon::now();
                        }
                    }
                    
                    $daysSinceLastSJ = \Carbon\Carbon::parse('2025-05-31')->diffInDays($endDate);
                }
                
                return (object)[
                    'KodeBrg' => $kodeBarang,
                    'NamaBrg' => $item->NamaBrg ?? 'N/A',
                    'SaldoAkhirCrt' => $item->SaldoAkhirCrt,
                    'SaldoAkhirKg' => $item->SaldoAkhirKg,
                    'Periode' => $item->Periode,
                    'TglKeluar' => $tglKeluar,
                    'DaysSinceLastSJ' => $daysSinceLastSJ
                ];
            });
            
            // Calculate chart data from ALL items before any filtering/pagination
            $stockBeforeFilter = $stock; // Keep reference to all data
            $chartData = [
                '1-3' => 0,
                '4-6' => 0, 
                '6-12' => 0,
                '12+' => 0,
                'no-data' => 0
            ];
            
            // Count all items for chart
            foreach ($stockBeforeFilter as $item) {
                $days = $item->DaysSinceLastSJ ?? 9999;
                
                if ($days >= 9999 || is_null($days)) {
                    $chartData['no-data']++;
                } elseif ($days <= 90) {
                    $chartData['1-3']++;
                } elseif ($days <= 180) {
                    $chartData['4-6']++;
                } elseif ($days <= 365) {
                    $chartData['6-12']++;
                } else {
                    $chartData['12+']++;
                }
            }
            
            // Apply age filter if specified BEFORE pagination
            if ($ageFilter) {
                $stock = $stock->filter(function($item) use ($ageFilter) {
                    $days = $item->DaysSinceLastSJ;
                    
                    switch ($ageFilter) {
                        case '1-3':
                            return $days <= 90;
                        case '4-6':
                            return $days > 90 && $days <= 180;
                        case '6-12':
                            return $days > 180 && $days <= 365;
                        case '12+':
                            return $days > 365;
                        case 'no-data':
                            return is_null($days) || $days >= 9999;
                        default:
                            return true;
                    }
                });
                
                // Update total count after filtering
                $totalItems = $stock->count();
                
                // Apply pagination to filtered results
                $stock = $stock->slice($offset, $perPage)->values();
            } else {
                // No filter, set total and apply pagination
                $totalItems = $totalItemsBeforeFilter;
                $stock = $stock->slice($offset, $perPage)->values();
            }
            
            // Calculate statistics
            $totalCrt = $stock->sum('SaldoAkhirCrt');
            $totalKg = $stock->sum('SaldoAkhirKg');
            
            // Categories based on stock levels
            $deadstockCategories = collect([
                'High Stock (>1000 Crt)' => $stock->filter(fn($item) => $item->SaldoAkhirCrt > 1000),
                'Medium Stock (100-1000 Crt)' => $stock->filter(fn($item) => $item->SaldoAkhirCrt >= 100 && $item->SaldoAkhirCrt <= 1000),
                'Low Stock (<100 Crt)' => $stock->filter(fn($item) => $item->SaldoAkhirCrt < 100 && $item->SaldoAkhirCrt > 0)
            ]);
            
            // Statistics for charts
            $stockWithSJ = $stock->filter(fn($item) => $item->TglKeluar !== null);
            $stockWithoutSJ = $stock->filter(fn($item) => $item->TglKeluar === null);
            $avgDeadstockDays = $stockWithSJ->count() > 0 ? 
                $stockWithSJ->map(fn($item) => \Carbon\Carbon::parse($item->TglKeluar)->diffInDays(\Carbon\Carbon::now()))->avg() : 0;
            
            // Calculate warehouse capacity utilization
            $maxKapasitasTon = 1000; // Maximum warehouse capacity: 1000 tons
            
            // Get total weight from all items with BeratStandart
            $totalBeratKg = DB::connection('firebird2')->selectOne('
                SELECT 
                    SUM(p."SaldoAkhirCrt" * COALESCE(b."BeratStandart", 0)) as TotalBeratKg,
                    COUNT(*) as TotalItems,
                    COUNT(CASE WHEN b."BeratStandart" > 0 THEN 1 END) as ItemsWithWeight
                FROM "TPersediaan" p
                LEFT JOIN "TBarangConv" b ON p."KodeBrg" = b."KodeBrg"
                WHERE p."Periode" LIKE ?
                    AND p."SaldoAkhirCrt" > 0
            ', ['%' . $periode . '%']);
            
            $totalBeratKg = $totalBeratKg->TOTALBERATKG ?? 0;
            $totalTon = $totalBeratKg / 1000;
            $sisaKapasitasTon = $maxKapasitasTon - $totalTon;
            $persentasePenggunaan = ($totalTon / $maxKapasitasTon) * 100;
            
            // Capacity data for chart (in tons)
            $capacityData = [
                'terpakai' => round($totalTon, 2),
                'tersisa' => round($sisaKapasitasTon, 2),
                'persentase' => round($persentasePenggunaan, 2),
                'max_kapasitas' => $maxKapasitasTon,
                'total_kg' => round($totalBeratKg, 2),
                'items_with_weight' => $totalBeratKg->ITEMSWITHWEIGHT ?? 0
            ];
            
            // Pagination data
            $pagination = [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $totalItems,
                'last_page' => ceil($totalItems / $perPage),
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $totalItems)
            ];

            // dd($stock);

            return view('admin.reports.deadstock', compact(
                'stock', 'periode', 'totalItems', 'totalCrt', 'totalKg',
                'deadstockCategories', 'stockWithSJ', 'stockWithoutSJ', 
                'avgDeadstockDays', 'pagination', 'ageFilter', 'chartData', 'capacityData'
            ));
            
        } catch (\Exception $e) {
            if (DB::connection('firebird2')->transactionLevel() > 0) {
                DB::connection('firebird2')->rollback();
            }
            
            \Illuminate\Support\Facades\Log::error('Optimized Deadstock Error: ' . $e->getMessage());
            
            return view('admin.reports.deadstock')->with('error', 'Error loading data: ' . $e->getMessage());
        }
    }

    public function exportDeadstockExcel(Request $request)
    {
        try {
            $periode = $request->periode ?? date('m/Y');
            
            $startTime = microtime(true);
            \Illuminate\Support\Facades\Log::info("Starting deadstock Excel export for periode: {$periode}");
            
            DB::connection('firebird2')->beginTransaction();
            
            // Get SJ data (reuse cache if available)
            $cacheKey = "latest_sj_data_{$periode}_v2";
            $latestSJData = \Illuminate\Support\Facades\Cache::remember($cacheKey, 5, function() use ($periode) {
                try {
                    return DB::connection('firebird2')->select('
                         d."KodeBrg" as KodeBrg,
                            MAX(s."TglPHP") as LatestTglPHP
                        FROM "TDetPHP" d
                        LEFT JOIN "TPHP" s ON d."NoPHP" = s."NoBukti"
                        WHERE EXTRACT(MONTH FROM s."TglPHP") <= EXTRACT(MONTH FROM CAST(? AS DATE))
                          AND EXTRACT(YEAR FROM s."TglPHP") <= EXTRACT(YEAR FROM CAST(? AS DATE))
                        GROUP BY d."KodeBrg"
                    ', [
                        '01/' . $periode,
                        '01/' . $periode
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Failed to load SJ data for export: ' . $e->getMessage());
                    return collect([]);
                }
            });

            dd($latestSJData);

            // Process SJ lookup
            $sjLookup = collect($latestSJData)->mapWithKeys(function($item) {
                $trimmedKey = trim($item->KODEBRG ?? '');
                return [$trimmedKey => $item->LATESTTGLPHP ?? null];
            });

            // dd($sjLookup);

            // Get ALL deadstock data (no pagination for export)
            $persediaan = DB::connection('firebird2')->select('
                SELECT 
                    p."KodeBrg",
                    b."NamaBrg",
                    p."SaldoAkhirCrt", 
                    p."SaldoAkhirKg",
                    p."Periode"
                FROM "TPersediaan" p
                LEFT JOIN "TBarangConv" b ON p."KodeBrg" = b."KodeBrg"
                WHERE p."Periode" LIKE ?
                    AND (p."SaldoAkhirCrt" > 0 OR p."SaldoAkhirKg" > 0)
                ORDER BY p."SaldoAkhirCrt" DESC
            ', ['%'.$periode.'%']);

            DB::connection('firebird2')->commit();

            // Process stock data with SJ lookup
            $stock = collect($persediaan)->map(function($item) use ($sjLookup) {
                $trimmedKode = trim($item->KodeBrg ?? '');
                $lastSJDate = $sjLookup->get($trimmedKode);
                
                $daysSinceLastSJ = null;
                if ($lastSJDate) {
                    $sjDate = \Carbon\Carbon::parse($lastSJDate);
                    $now = \Carbon\Carbon::now();
                    $daysSinceLastSJ = $now->diffInDays($sjDate);
                }

                return (object) [
                    'KodeBrg' => $trimmedKode,
                    'SaldoAkhirCrt' => $item->SaldoAkhirCrt ?? 0,
                    'SaldoAkhirKg' => $item->SaldoAkhirKg ?? 0,
                    'Periode' => $item->Periode,
                    'LastSJDate' => $lastSJDate,
                    'DaysSinceLastSJ' => $daysSinceLastSJ,
                    'DeadstockCategory' => $this->getDeadstockCategory($item->SaldoAkhirCrt ?? 0, $daysSinceLastSJ)
                ];
            });

            $loadTime = round((microtime(true) - $startTime) * 1000, 2);
            \Illuminate\Support\Facades\Log::info("Export data loaded in {$loadTime}ms, processing " . $stock->count() . " total items");

            // Create Excel file - sanitize periode for filename
            $sanitizedPeriode = str_replace('/', '-', $periode);
            $filename = "deadstock_report_{$sanitizedPeriode}_" . date('Ymd_His') . ".xlsx";
            
            $totalTime = round((microtime(true) - $startTime) * 1000, 2);
            \Illuminate\Support\Facades\Log::info("Excel export completed in {$totalTime}ms for " . ($stock->count()) . " items");

            // Export menggunakan Laravel Excel
            return Excel::download(new DeadstockExport($stock), $filename);

        } catch (\Exception $e) {
            if (DB::connection('firebird2')->transactionLevel() > 0) {
                DB::connection('firebird2')->rollback();
            }
            
            \Illuminate\Support\Facades\Log::error('Deadstock Export Error: ' . $e->getMessage());
            
            return response("Export error: " . $e->getMessage(), 500);
        }
    }

    private function getDeadstockCategory($saldoAkhirCrt, $daysSinceLastSJ)
    {
        if (is_null($daysSinceLastSJ)) {
            return 'No SJ History';
        }
        
        if ($daysSinceLastSJ > 90) {
            return 'Critical Deadstock (>90 days)';
        } elseif ($daysSinceLastSJ > 60) {
            return 'High Deadstock (60-90 days)';
        } elseif ($daysSinceLastSJ > 30) {
            return 'Medium Deadstock (30-60 days)';
        } else {
            return 'Active Stock (<30 days)';
        }
    }

    public function kapasitasGudang(Request $request)
    {
        $periode = $request->periode ?? date_format(now(), 'm/Y');

        $startTime = microtime(true);
        \Illuminate\Support\Facades\Log::info("Starting kapasitas gudang report for periode: {$periode}");

        try {
            DB::connection('firebird2')->beginTransaction();

            // Optimized query without LIMIT - focus on WHERE clause optimization
            $queryStartTime = microtime(true);
            
            // Split into smaller, faster queries
            $gudangData = DB::connection('firebird2')->select('
                SELECT 
                    p."KodeBrg",
                    p."SaldoAkhirKg",
                    p."SaldoAkhirCrt", 
                    p."Periode",
                    b."NamaBrg",
                    b."JenisProd",
                    pc."Nama"
                FROM "TPersediaan" p
                INNER JOIN "TBarangConv" b ON p."KodeBrg" = b."KodeBrg"
                LEFT JOIN "TProdConv" pc ON b."JenisProd" = pc."Kode"
                WHERE p."Periode" = ?
                    AND p."SaldoAkhirCrt" > 0
                    AND p."SaldoAkhirKg" > 0
                    AND b."KodeBrg" IS NOT NULL
                ORDER BY p."SaldoAkhirKg" DESC
            ', [$periode]);

            $queryEndTime = microtime(true);
            $queryTime = round(($queryEndTime - $queryStartTime) * 1000, 2);
            
            \Illuminate\Support\Facades\Log::info("Kapasitas query completed in {$queryTime}ms. Records found: " . count($gudangData));

            DB::connection('firebird2')->commit();

            // Efficient pre-calculations using single pass
            $totalKg = 0;
            $totalCrt = 0;
            $totalItems = count($gudangData);
            
            foreach ($gudangData as $item) {
                $totalKg += (float)($item->SaldoAkhirKg ?? 0);
                $totalCrt += (float)($item->SaldoAkhirCrt ?? 0);
            }

            $totals = [
                'totalKg' => $totalKg,
                'totalCrt' => $totalCrt, 
                'totalItems' => $totalItems,
                'percentage' => $totalKg > 0 ? ($totalKg / 1000000) * 100 : 0
            ];

            $totalTime = round((microtime(true) - $startTime) * 1000, 2);
            \Illuminate\Support\Facades\Log::info("Kapasitas gudang report completed in {$totalTime}ms");

            return view('admin.reports.kapasitas_gudang', compact('gudangData', 'periode', 'totals'));
            
        } catch (\Exception $e) {
            if (DB::connection('firebird2')->transactionLevel() > 0) {
                DB::connection('firebird2')->rollback();
            }
            
            \Illuminate\Support\Facades\Log::error('Kapasitas Gudang Error: ' . $e->getMessage());
            
            // Return empty data on error
            $totals = ['totalKg' => 0, 'totalCrt' => 0, 'totalItems' => 0, 'percentage' => 0];
            $gudangData = [];
            
            return view('admin.reports.kapasitas_gudang', compact('gudangData', 'periode', 'totals'))
                ->with('error', 'Terjadi kesalahan saat memuat data kapasitas gudang.');
        }
    }

    public function in_out_bound(Request $request)
    {
        $periode = $request->periode ?? date_format(now(), 'm/Y');
        
        try {
            \Illuminate\Support\Facades\Log::info("Starting in_out_bound report for periode: {$periode}");
            
            DB::connection('firebird2')->beginTransaction();
            
            // Parse periode
            $periodeParts = explode('/', $periode);
            $month = intval($periodeParts[0] ?? 0);
            $year = intval($periodeParts[1] ?? 0);
            
            if ($month == 0 || $year == 0) {
                throw new \Exception("Invalid periode format: {$periode}");
            }
            
            \Illuminate\Support\Facades\Log::info("Parsed periode: Month={$month}, Year={$year}");
            
            // Jika ada parameter test, gunakan data sample kecil
            if ($request->has('test')) {
                return $this->in_out_bound_test($request, $month, $year);
            }
            
            // DEBUG: Check available tables and their structure
            try {
                $sjTables = DB::connection('firebird2')->select('
                    SELECT RDB$RELATION_NAME 
                    FROM RDB$RELATIONS 
                    WHERE RDB$RELATION_NAME LIKE \'%SJ%\' OR RDB$RELATION_NAME LIKE \'%SURAT%\'
                    ORDER BY RDB$RELATION_NAME
                ');
                \Illuminate\Support\Facades\Log::info("Available SJ tables: " . json_encode($sjTables));
                
                $phpTables = DB::connection('firebird2')->select('
                    SELECT RDB$RELATION_NAME 
                    FROM RDB$RELATIONS 
                    WHERE RDB$RELATION_NAME LIKE \'%PHP%\'
                    ORDER BY RDB$RELATION_NAME
                ');
                \Illuminate\Support\Facades\Log::info("Available PHP tables: " . json_encode($phpTables));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Could not query table structure: " . $e->getMessage());
            }
            
            // Query untuk mendapatkan data SJ (Outbound) - LIMIT untuk testing
            \Illuminate\Support\Facades\Log::info("Executing SJ query for month={$month}, year={$year}");
            $sjData = DB::connection('firebird2')->select('
                SELECT 
                    CAST(sj."TglSJ" AS DATE) as tanggal,
                    det."KodeBrg",
                    b."NamaBrg",
                    b."BeratStandart",
                    SUM(det."Quantity" * COALESCE(b."BeratStandart", 0)) as total_berat,
                    COUNT(DISTINCT sj."NomerSJ") as total_dokumen,
                    \'SJ\' as jenis_transaksi
                FROM "TDetSJ" det
                LEFT JOIN "TSuratJalan" sj ON det."NomerSJ" = sj."NomerSJ"
                LEFT JOIN "TBarangConv" b ON det."KodeBrg" = b."KodeBrg"
                WHERE EXTRACT(MONTH FROM sj."TglSJ") = ? 
                    AND EXTRACT(YEAR FROM sj."TglSJ") = ?
                    AND det."Quantity" > 0
                    AND sj."TglSJ" IS NOT NULL
                GROUP BY 
                    CAST(sj."TglSJ" AS DATE),
                    det."KodeBrg", 
                    b."NamaBrg",
                    b."BeratStandart"
                ORDER BY tanggal DESC, det."KodeBrg"
            ', [$month, $year]);

            // dd($sjData);
            
            // Query untuk mendapatkan data PHP (Inbound) - LIMIT untuk testing
            \Illuminate\Support\Facades\Log::info("Executing PHP query for month={$month}, year={$year}");
            $phpData = DB::connection('firebird2')->select('
                SELECT 
                    CAST(php."TglPHP" AS DATE) as tanggal,
                    det."KodeBrg",
                    b."NamaBrg",
                    b."BeratStandart",
                    SUM(det."Berat") as total_berat,
                    COUNT(DISTINCT php."NoBukti") as total_dokumen,
                    \'PHP\' as jenis_transaksi
                FROM "TDetPHP" det
                LEFT JOIN "TPHP" php ON det."NoPHP" = php."NoBukti"
                LEFT JOIN "TBarangConv" b ON det."KodeBrg" = b."KodeBrg"
                WHERE EXTRACT(MONTH FROM php."TglPHP") = ? 
                    AND EXTRACT(YEAR FROM php."TglPHP") = ?
                    AND det."Berat" > 0
                    AND php."TglPHP" IS NOT NULL
                GROUP BY 
                    CAST(php."TglPHP" AS DATE),
                    det."KodeBrg", 
                    b."NamaBrg",
                    b."BeratStandart"
                ORDER BY tanggal DESC, det."KodeBrg"
            ', [$month, $year]);
            
            DB::connection('firebird2')->commit();
            
            \Illuminate\Support\Facades\Log::info("Query completed. SJ count: " . count($sjData) . ", PHP count: " . count($phpData));
            
            // Gabungkan dan olah data
            $combinedData = collect($sjData)->merge(collect($phpData));
            
            \Illuminate\Support\Facades\Log::info("Combined data count: " . $combinedData->count());
            
            // Group by tanggal saja untuk menggabungkan semua transaksi per hari
            // Note: Field names in Firebird are typically uppercase
            $groupedData = $combinedData->groupBy(function($item) {
                // Try multiple possible field names for tanggal
                if (property_exists($item, 'TANGGAL')) {
                    return $item->TANGGAL;
                } elseif (property_exists($item, 'tanggal')) {
                    return $item->tanggal;
                } elseif (property_exists($item, 'TGL')) {
                    return $item->TGL;
                } else {
                    // Fallback - use the first property that looks like a date
                    $props = get_object_vars($item);
                    foreach ($props as $key => $value) {
                        if (stripos($key, 'tanggal') !== false || stripos($key, 'tgl') !== false) {
                            return $value;
                        }
                    }
                    return 'unknown_date';
                }
            })->map(function($group, $tanggal) {
                // Filter dengan trim untuk mengatasi whitespace di JENIS_TRANSAKSI
                $sjItems = $group->filter(function($item) {
                    $jenisTransaksi = trim($item->JENIS_TRANSAKSI ?? '');
                    return $jenisTransaksi === 'SJ';
                });
                
                $phpItems = $group->filter(function($item) {
                    $jenisTransaksi = trim($item->JENIS_TRANSAKSI ?? '');
                    return $jenisTransaksi === 'PHP';
                });

                // dd($tanggal, $sjItems->sum('TOTAL_BERAT'), $phpItems);
                
                $totalQtySJ = $sjItems->sum('TOTAL_BERAT') ?? 0;
                $totalQtyPHP = $phpItems->sum('TOTAL_BERAT') ?? 0;
                $totalSJDokumen = $sjItems->sum('TOTAL_DOKUMEN') ?? 0;
                $totalPHPDokumen = $phpItems->sum('TOTAL_DOKUMEN') ?? 0;
                
                // Ambil daftar barang yang terlibat
                $kodeBarangField = null;
                if ($group->count() > 0) {
                    $firstItem = $group->first();
                    if (property_exists($firstItem, 'KodeBrg')) {
                        $kodeBarangField = 'KodeBrg';
                    } elseif (property_exists($firstItem, 'KODEBRG')) {
                        $kodeBarangField = 'KODEBRG';
                    }
                }
                
                $totalItemTypes = 0;
                
                if ($kodeBarangField) {
                    $uniqueCodes = $group->pluck($kodeBarangField)->unique();
                    $totalItemTypes = $uniqueCodes->count();
                }
                
                return (object)[
                    'tanggal' => $tanggal,
                    'total_item_types' => $totalItemTypes,
                    'qtySJ' => $totalQtySJ,
                    'qtyPHP' => $totalQtyPHP,
                    'total_sj' => $totalSJDokumen,
                    'total_php' => $totalPHPDokumen
                ];
            })->sortByDesc('tanggal')->values();
            
            $inOutData = $groupedData;
            
            \Illuminate\Support\Facades\Log::info("Data processing completed. Final count: " . $inOutData->count());
            
        } catch (\Exception $e) {
            if (DB::connection('firebird2')->transactionLevel() > 0) {
                DB::connection('firebird2')->rollback();
            }
            
            \Illuminate\Support\Facades\Log::error('In/Out Bound Report Error: ' . $e->getMessage());
            
            // Return empty collection on error
            $inOutData = collect();
        }

        return view('admin.reports.in_out_bound', compact('inOutData', 'periode'));
    }
    
    public function in_out_bound_test(Request $request, $month, $year)
    {
        // Test dengan data statis untuk debug
        $testData = collect([
            (object)[
                'tanggal' => '2025-10-01', 
                'jenis_transaksi' => 'SJ',
                'total_berat' => 100,
                'total_dokumen' => 5,
                'KodeBrg' => 'TEST001',
                'NamaBrg' => 'Test Barang SJ'
            ],
            (object)[
                'tanggal' => '2025-10-01', 
                'jenis_transaksi' => 'PHP',
                'total_berat' => 150,
                'total_dokumen' => 3,
                'KodeBrg' => 'TEST002',
                'NamaBrg' => 'Test Barang PHP'
            ],
            (object)[
                'tanggal' => '2025-10-02', 
                'jenis_transaksi' => 'SJ ',  // dengan whitespace
                'total_berat' => 80,
                'total_dokumen' => 2,
                'KodeBrg' => 'TEST003',
                'NamaBrg' => 'Test Barang SJ 2'
            ]
        ]);
        
        \Illuminate\Support\Facades\Log::info("Using test data count: " . $testData->count());
        
        // Group by tanggal
        $groupedData = $testData->groupBy('tanggal')->map(function($group, $tanggal) {
            // Debug: Check jenis_transaksi values
            $jenisValues = $group->map(function($item) {
                return "'" . $item->jenis_transaksi . "' (length:" . strlen($item->jenis_transaksi) . ")";
            })->unique()->values()->toArray();
            
            \Illuminate\Support\Facades\Log::info("Date {$tanggal} - All JENIS_TRANSAKSI values: " . json_encode($jenisValues));
            
            // Filter dengan trim
            $sjItems = $group->filter(function($item) {
                $jenisTransaksi = trim($item->jenis_transaksi ?? '');
                return $jenisTransaksi === 'SJ';
            });
            
            $phpItems = $group->filter(function($item) {
                $jenisTransaksi = trim($item->jenis_transaksi ?? '');
                return $jenisTransaksi === 'PHP';
            });
            
            \Illuminate\Support\Facades\Log::info("Date {$tanggal}: Total items: {$group->count()}, SJ items: {$sjItems->count()}, PHP items: {$phpItems->count()}");
            
            return (object)[
                'tanggal' => $tanggal,
                'daftar_barang' => 'TEST_ITEMS',
                'total_item_types' => $group->count(),
                'qtySJ' => $sjItems->sum('total_berat'),
                'qtyPHP' => $phpItems->sum('total_berat'),
                'total_sj' => $sjItems->sum('total_dokumen'),
                'total_php' => $phpItems->sum('total_dokumen')
            ];
        })->sortByDesc('tanggal')->values();
        
        $inOutData = $groupedData;
        $periode = $month . '/' . $year;
        
        return view('admin.reports.in_out_bound', compact('inOutData', 'periode'));
    }
}
