<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    DB::connection('firebird2')->beginTransaction();
    
    echo "=== DEBUG KEY MAPPING ===\n\n";
    
    $targetKode = 'LDE.01.01.S50.33431.002';
    
    // 1. Get SJ data
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
    
    // 2. Find target in raw data
    $foundInRaw = null;
    foreach ($latestSJData as $item) {
        if (trim($item->KODEBRG) === $targetKode) {
            $foundInRaw = $item;
            break;
        }
    }
    
    if ($foundInRaw) {
        echo "✅ Found in raw SJ data:\n";
        echo "   Raw KODEBRG: '" . $foundInRaw->KODEBRG . "'\n";
        echo "   Length: " . strlen($foundInRaw->KODEBRG) . "\n";
        echo "   Trimmed: '" . trim($foundInRaw->KODEBRG) . "'\n";
        echo "   Trimmed Length: " . strlen(trim($foundInRaw->KODEBRG)) . "\n";
    } else {
        echo "❌ NOT found in raw SJ data\n";
    }
    
    // 3. Process mapWithKeys sama seperti controller
    $sjLookup = collect($latestSJData)->mapWithKeys(function($item) {
        $trimmedKey = trim($item->KODEBRG ?? '');
        return [$trimmedKey => $item];
    })->filter(function($item, $key) {
        return !empty($key);
    });
    
    echo "\n📋 SJ Lookup keys containing target:\n";
    $matchingKeys = $sjLookup->keys()->filter(function($key) use ($targetKode) {
        return $key === $targetKode;
    });
    
    foreach ($matchingKeys as $key) {
        echo "   Found key: '{$key}'\n";
    }
    
    // 4. Test lookup sama seperti di controller
    echo "\n🔍 Controller simulation:\n";
    
    // Get persediaan data for target
    $persediaan = DB::connection('firebird2')->select('
        SELECT 
            p."KodeBrg",
            p."SaldoAkhirCrt"
        FROM "TPersediaan" p
        WHERE TRIM(p."KodeBrg") = ?
            AND p."Periode" LIKE ?
    ', [trim($targetKode), '%10/2025%']);
    
    if (!empty($persediaan)) {
        $item = $persediaan[0];
        $kodeBarang = trim($item->KodeBrg ?? '');
        echo "   Persediaan KodeBrg: '{$kodeBarang}'\n";
        echo "   Persediaan KodeBrg Length: " . strlen($kodeBarang) . "\n";
        
        $latestSJ = $sjLookup->get($kodeBarang);
        
        if ($latestSJ) {
            echo "   ✅ Found in SJ lookup using persediaan key\n";
            echo "   SJ LATESTTGLPHP: {$latestSJ->LATESTTGLPHP}\n";
        } else {
            echo "   ❌ NOT found in SJ lookup using persediaan key\n";
            
            // Try manual search
            echo "   🔍 Manual search in SJ lookup:\n";
            foreach ($sjLookup as $sjKey => $sjItem) {
                if ($sjKey === $kodeBarang) {
                    echo "      ✅ EXACT match found!\n";
                    break;
                } elseif (trim($sjKey) === trim($kodeBarang)) {
                    echo "      ✅ TRIMMED match found!\n";
                    break;
                } elseif (str_contains($sjKey, $targetKode) || str_contains($targetKode, $sjKey)) {
                    echo "      🔍 Similar: '{$sjKey}'\n";
                }
            }
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