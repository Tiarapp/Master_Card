<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $kodeBarang = 'LDE.01.01.S50.33431.002';
    $periode = '10/2025';
    
    echo "=== DEBUG BARANG: {$kodeBarang} ===\n\n";
    
    // Start transaction
    DB::connection('firebird2')->beginTransaction();
    
    // 1. Cek data di TPersediaan
    echo "1. Data di TPersediaan:\n";
    $persediaan = DB::connection('firebird2')->select('
        SELECT 
            p."KodeBrg",
            b."NamaBrg",
            p."SaldoAkhirCrt", 
            p."SaldoAkhirKg",
            p."Periode"
        FROM "TPersediaan" p
        LEFT JOIN "TBarangConv" b ON p."KodeBrg" = b."KodeBrg"
        WHERE TRIM(p."KodeBrg") = ?
            AND p."Periode" LIKE ?
    ', [trim($kodeBarang), '%' . $periode . '%']);
    
    if (empty($persediaan)) {
        echo "   ❌ TIDAK DITEMUKAN di TPersediaan untuk periode {$periode}\n";
        
        // Cek periode lain
        $allPeriodes = DB::connection('firebird2')->select('
            SELECT DISTINCT p."Periode"
            FROM "TPersediaan" p
            WHERE TRIM(p."KodeBrg") = ?
            ORDER BY p."Periode" DESC
        ', [trim($kodeBarang)]);
        
        echo "   📅 Periode yang tersedia untuk barang ini:\n";
        foreach ($allPeriodes as $p) {
            echo "      - {$p->Periode}\n";
        }
    } else {
        foreach ($persediaan as $item) {
            echo "   ✅ KodeBrg: {$item->KodeBrg}\n";
            echo "   📦 NamaBrg: {$item->NamaBrg}\n";
            echo "   📊 SaldoAkhirCrt: {$item->SaldoAkhirCrt}\n";
            echo "   📊 SaldoAkhirKg: {$item->SaldoAkhirKg}\n";
            echo "   📅 Periode: {$item->Periode}\n";
        }
    }
    
    echo "\n";
    
    // 2. Cek data SJ/PHP
    echo "2. Data SJ/PHP (TDetPHP + TPHP):\n";
    $sjData = DB::connection('firebird2')->select('
        SELECT 
            d."KodeBrg" as KodeBrg,
            s."TglPHP" as TglPHP,
            s."NoBukti" as NoBukti
        FROM "TDetPHP" d
        LEFT JOIN "TPHP" s ON d."NoPHP" = s."NoBukti"
        WHERE TRIM(d."KodeBrg") = ?
        ORDER BY s."TglPHP" DESC
    ', [trim($kodeBarang)]);
    
    if (empty($sjData)) {
        echo "   ❌ TIDAK DITEMUKAN data SJ/PHP\n";
    } else {
        echo "   ✅ Ditemukan " . count($sjData) . " transaksi SJ/PHP:\n";
        foreach (array_slice($sjData, 0, 5) as $sj) {
            echo "      - TglPHP: {$sj->TGLPHP}, NoBukti: {$sj->NOBUKTI}\n";
        }
        
        // Ambil yang terbaru
        $latestSJ = $sjData[0];
        echo "   🕒 Transaksi terakhir: {$latestSJ->TGLPHP}\n";
        
        // Hitung hari
        $tglPHP = \Carbon\Carbon::parse($latestSJ->TGLPHP);
        $endOfPeriod = \Carbon\Carbon::create(2025, 10)->endOfMonth();
        $daysDiff = $tglPHP->diffInDays($endOfPeriod);
        
        echo "   📊 Hari dari transaksi terakhir ke akhir periode: {$daysDiff} hari\n";
        
        // Kategorisasi
        if ($daysDiff <= 90) {
            echo "   🟢 Kategori: 1-3 bulan (≤90 hari)\n";
        } elseif ($daysDiff <= 180) {
            echo "   🟡 Kategori: 4-6 bulan (90-180 hari)\n";
        } elseif ($daysDiff <= 365) {
            echo "   🔴 Kategori: 6-1 tahun (180-365 hari)\n";
        } else {
            echo "   ⚫ Kategori: 1 tahun++ (>365 hari)\n";
        }
    }
    
    echo "\n";
    
    // 3. Cek logika yang sama dengan controller
    echo "3. Simulasi logika controller:\n";
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
    
    $sjLookup = collect($latestSJData)->mapWithKeys(function($item) {
        $trimmedKey = trim($item->KODEBRG ?? '');
        return [$trimmedKey => $item];
    })->filter(function($item, $key) {
        return !empty($key);
    });
    
    $trimmedKode = trim($kodeBarang);
    $latestSJ = $sjLookup->get($trimmedKode);
    
    echo "   🔍 Trimmed KodeBrg: '{$trimmedKode}'\n";
    echo "   📋 SJ Lookup count: {$sjLookup->count()}\n";
    
    if ($latestSJ && !empty($latestSJ->LATESTTGLPHP)) {
        echo "   ✅ Found in SJ lookup: {$latestSJ->LATESTTGLPHP}\n";
        
        $tglKeluar = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->toDateString();
        $endDate = \Carbon\Carbon::create(2025, 10)->endOfMonth();
        $daysSinceLastSJ = \Carbon\Carbon::parse($latestSJ->LATESTTGLPHP)->diffInDays($endDate);
        
        echo "   📅 TglKeluar: {$tglKeluar}\n";
        echo "   📊 DaysSinceLastSJ: {$daysSinceLastSJ}\n";
    } else {
        echo "   ❌ NOT FOUND in SJ lookup - akan menggunakan default 31/05/2025\n";
        
        $tglKeluar = '2025-05-31';
        $endDate = \Carbon\Carbon::create(2025, 10)->endOfMonth();
        $daysSinceLastSJ = \Carbon\Carbon::parse('2025-05-31')->diffInDays($endDate);
        
        echo "   📅 TglKeluar (default): {$tglKeluar}\n";
        echo "   📊 DaysSinceLastSJ (default): {$daysSinceLastSJ}\n";
    }
    
    // Cek kondisi view
    echo "\n4. Kondisi tampilan di view:\n";
    if ($daysSinceLastSJ && $daysSinceLastSJ < 9999) {
        echo "   ✅ Akan menampilkan badge dengan {$daysSinceLastSJ} hari\n";
    } else {
        echo "   ❌ Akan menampilkan 'No Data'\n";
    }
    
    echo "\n=== SELESAI ===\n";
    
    // Commit transaction
    DB::connection('firebird2')->commit();
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}