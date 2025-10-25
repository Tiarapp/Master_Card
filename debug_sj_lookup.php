<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    DB::connection('firebird2')->beginTransaction();
    
    echo "=== DEBUG SJ LOOKUP STRUCTURE ===\n\n";
    
    // Get SJ data sama seperti di controller
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
    
    echo "Raw SJ data count: " . count($latestSJData) . "\n";
    
    // Process sama seperti di controller
    $sjLookup = collect($latestSJData)->mapWithKeys(function($item) {
        $trimmedKey = trim($item->KODEBRG ?? '');
        return [$trimmedKey => $item];
    })->filter(function($item, $key) {
        return !empty($key);
    });
    
    echo "SJ Lookup count after processing: " . $sjLookup->count() . "\n\n";
    
    // Check specific item
    $targetKode = 'LDE.01.01.S50.33431.002';
    $trimmedKode = trim($targetKode);
    
    echo "Looking for: '{$trimmedKode}'\n";
    
    $latestSJ = $sjLookup->get($trimmedKode);
    
    if ($latestSJ) {
        echo "✅ Found in SJ lookup:\n";
        echo "   Structure: " . json_encode($latestSJ) . "\n";
        echo "   LATESTTGLPHP: " . ($latestSJ->LATESTTGLPHP ?? 'MISSING') . "\n";
        echo "   Property exists: " . (property_exists($latestSJ, 'LATESTTGLPHP') ? 'YES' : 'NO') . "\n";
        
        // Test kondisi dari controller
        if ($latestSJ && !empty($latestSJ->LATESTTGLPHP)) {
            echo "   ✅ Controller condition TRUE: Will process date\n";
            
            $tglKeluar = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->toDateString();
            $endDate = \Carbon\Carbon::create(2025, 10)->endOfMonth();
            $daysSinceLastSJ = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->diffInDays($endDate);
            
            echo "   📅 TglKeluar: {$tglKeluar}\n";
            echo "   📊 DaysSinceLastSJ: {$daysSinceLastSJ}\n";
        } else {
            echo "   ❌ Controller condition FALSE: Will use default\n";
            echo "   🔍 Reason: empty LATESTTGLPHP = '" . ($latestSJ->LATESTTGLPHP ?? 'null') . "'\n";
        }
    } else {
        echo "❌ NOT found in SJ lookup\n";
        
        echo "\n🔍 Checking available keys (first 10):\n";
        $keys = $sjLookup->keys()->take(10);
        foreach ($keys as $key) {
            echo "   - '{$key}'\n";
        }
        
        echo "\n🔍 Checking if similar keys exist:\n";
        $similarKeys = $sjLookup->keys()->filter(function($key) use ($trimmedKode) {
            return str_contains($key, 'LDE.01.01.S50.33431') || str_contains($trimmedKode, $key);
        });
        
        foreach ($similarKeys as $key) {
            echo "   Similar: '{$key}'\n";
        }
    }
    
    DB::connection('firebird2')->commit();
    
    echo "\n=== SELESAI ===\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    if (DB::connection('firebird2')->transactionLevel() > 0) {
        DB::connection('firebird2')->rollback();
    }
}