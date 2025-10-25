<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $periode = '10/2025';
    $ageFilter = null;
    $perPage = 50;
    $page = 1;
    $offset = ($page - 1) * $perPage;
    
    $startTime = microtime(true);
    echo "=== FULL CONTROLLER DEBUG ===\n\n";
    
    DB::connection('firebird2')->beginTransaction();
    
    // Cache SJ data
    $cacheKey = "latest_sj_data_{$periode}_v2";
    \Illuminate\Support\Facades\Cache::forget($cacheKey); // Clear cache
    
    $latestSJData = DB::connection('firebird2')->select('
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

    // Convert to keyed collection
    $sjLookup = collect($latestSJData)->mapWithKeys(function($item) {
        $trimmedKey = trim($item->KODEBRG ?? '');
        return [$trimmedKey => $item];
    })->filter(function($item, $key) {
        return !empty($key);
    });

    // Get persediaan data
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

    DB::connection('firebird2')->commit();

    echo "SJ Lookup count: " . $sjLookup->count() . "\n";
    echo "Persediaan count: " . count($persediaan) . "\n\n";

    // Find target item in persediaan
    $targetKode = 'LDE.01.01.S50.33431.002';
    $targetItem = null;
    $targetIndex = -1;
    
    foreach ($persediaan as $index => $item) {
        if (trim($item->KodeBrg) === $targetKode) {
            $targetItem = $item;
            $targetIndex = $index;
            break;
        }
    }
    
    if ($targetItem) {
        echo "✅ Found target in persediaan at index: {$targetIndex}\n";
        echo "   KodeBrg: '{$targetItem->KodeBrg}'\n";
        echo "   SaldoAkhirCrt: {$targetItem->SaldoAkhirCrt}\n\n";
        
        // Simulate the mapping function exactly as in controller
        echo "🔄 Simulating controller mapping:\n";
        
        $kodeBarang = trim($targetItem->KodeBrg ?? '');
        echo "   Trimmed KodeBrg: '{$kodeBarang}'\n";
        
        $latestSJ = $sjLookup->get($kodeBarang);
        echo "   SJ Lookup result: " . ($latestSJ ? 'FOUND' : 'NOT FOUND') . "\n";
        
        if ($latestSJ) {
            echo "   SJ LATESTTGLPHP: " . ($latestSJ->LATESTTGLPHP ?? 'null') . "\n";
            echo "   isEmpty check: " . (empty($latestSJ->LATESTTGLPHP) ? 'EMPTY' : 'NOT EMPTY') . "\n";
        }
        
        // Variables to match controller exactly
        $daysSinceLastSJ = null;
        $tglKeluar = null;
        
        if ($latestSJ && !empty($latestSJ->LATESTTGLPHP)) {
            echo "   ✅ Condition MET: Processing date\n";
            
            $tglKeluar = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->toDateString();
            
            // Date calculation
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
            
            $daysSinceLastSJ = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->diffInDays($endDate);
            
            echo "   📅 TglKeluar: {$tglKeluar}\n";
            echo "   📊 DaysSinceLastSJ: {$daysSinceLastSJ}\n";
        } else {
            echo "   ❌ Condition NOT MET: Using default\n";
            
            $tglKeluar = '2025-05-31';
            
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
            
            echo "   📅 TglKeluar (default): {$tglKeluar}\n";
            echo "   📊 DaysSinceLastSJ (default): {$daysSinceLastSJ}\n";
        }
        
        // Create object exactly as controller
        $resultObject = (object)[
            'KodeBrg' => $kodeBarang,
            'NamaBrg' => $targetItem->NamaBrg ?? 'N/A',
            'SaldoAkhirCrt' => $targetItem->SaldoAkhirCrt,
            'SaldoAkhirKg' => $targetItem->SaldoAkhirKg,
            'Periode' => $targetItem->Periode,
            'TglKeluar' => $tglKeluar,
            'DaysSinceLastSJ' => $daysSinceLastSJ
        ];
        
        echo "\n📦 Final object:\n";
        echo "   KodeBrg: {$resultObject->KodeBrg}\n";
        echo "   TglKeluar: " . ($resultObject->TglKeluar ?: 'null') . "\n";
        echo "   DaysSinceLastSJ: " . ($resultObject->DaysSinceLastSJ ?: 'null') . "\n";
        
        // Test view condition
        echo "\n🎯 View condition test:\n";
        if ($resultObject->DaysSinceLastSJ && $resultObject->DaysSinceLastSJ < 9999) {
            echo "   ✅ Will show badge: {$resultObject->DaysSinceLastSJ} hari\n";
        } else {
            echo "   ❌ Will show 'No Data'\n";
            echo "   🔍 DaysSinceLastSJ value: " . var_export($resultObject->DaysSinceLastSJ, true) . "\n";
            echo "   🔍 DaysSinceLastSJ type: " . gettype($resultObject->DaysSinceLastSJ) . "\n";
        }
    }
    
    echo "\n=== SELESAI ===\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    if (DB::connection('firebird2')->transactionLevel() > 0) {
        DB::connection('firebird2')->rollback();
    }
}