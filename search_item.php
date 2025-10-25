<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate request
$request = new \Illuminate\Http\Request();
$request->merge(['periode' => '10/2025']);

$controller = new \App\Http\Controllers\ReportController();
$response = $controller->deadstock($request);

// Get the data passed to view
$viewData = $response->getData();
$stock = $viewData['stock'];

echo "=== SEARCH BARANG DI HASIL CONTROLLER ===\n\n";

$targetKode = 'LDE.01.01.S50.33431.002';
$found = false;

foreach ($stock as $index => $item) {
    if (trim($item->KodeBrg) === $targetKode) {
        $found = true;
        echo "✅ DITEMUKAN di halaman " . (intval($index / 50) + 1) . ", index: {$index}\n";
        echo "   📦 KodeBrg: {$item->KodeBrg}\n";
        echo "   📝 NamaBrg: {$item->NamaBrg}\n";
        echo "   📅 TglKeluar: " . ($item->TglKeluar ?: 'null') . "\n";
        echo "   📊 DaysSinceLastSJ: " . ($item->DaysSinceLastSJ ?: 'null') . "\n";
        echo "   💾 SaldoAkhirCrt: {$item->SaldoAkhirCrt}\n";
        
        // Test kondisi view
        if ($item->DaysSinceLastSJ && $item->DaysSinceLastSJ < 9999) {
            echo "   ✅ Kondisi: Akan tampil badge {$item->DaysSinceLastSJ} hari\n";
            
            if ($item->DaysSinceLastSJ <= 90) {
                echo "   🟢 Kategori: 1-3 bulan (badge-success)\n";
            } elseif ($item->DaysSinceLastSJ <= 180) {
                echo "   🟡 Kategori: 4-6 bulan (badge-warning)\n";
            } elseif ($item->DaysSinceLastSJ <= 365) {
                echo "   🔴 Kategori: 6-1 tahun (badge-danger)\n";
            } else {
                echo "   ⚫ Kategori: 1 tahun++ (badge-dark)\n";
            }
        } else {
            echo "   ❌ Kondisi: Akan tampil 'No Data'\n";
            echo "   🔍 Alasan: DaysSinceLastSJ = " . ($item->DaysSinceLastSJ ?: 'null') . "\n";
        }
        break;
    }
}

if (!$found) {
    echo "❌ TIDAK DITEMUKAN di hasil controller\n";
    echo "📊 Total items: " . count($stock) . "\n";
    echo "📄 Pagination info:\n";
    echo "   - Current page: " . $viewData['pagination']['current_page'] . "\n";
    echo "   - Per page: " . $viewData['pagination']['per_page'] . "\n";
    echo "   - Total: " . $viewData['pagination']['total'] . "\n";
    echo "   - From: " . $viewData['pagination']['from'] . "\n";
    echo "   - To: " . $viewData['pagination']['to'] . "\n";
    
    echo "\n🔍 Coba cari di halaman lain...\n";
    
    // Test dengan page 2, 3, dst
    for ($page = 2; $page <= 5; $page++) {
        $request2 = new \Illuminate\Http\Request();
        $request2->merge(['periode' => '10/2025', 'page' => $page]);
        
        try {
            $response2 = $controller->deadstock($request2);
            $viewData2 = $response2->getData();
            $stock2 = $viewData2['stock'];
            
            foreach ($stock2 as $index => $item) {
                if (trim($item->KodeBrg) === $targetKode) {
                    echo "✅ DITEMUKAN di halaman {$page}, index: {$index}\n";
                    echo "   📦 KodeBrg: {$item->KodeBrg}\n";
                    echo "   📅 TglKeluar: " . ($item->TglKeluar ?: 'null') . "\n";
                    echo "   📊 DaysSinceLastSJ: " . ($item->DaysSinceLastSJ ?: 'null') . "\n";
                    
                    if ($item->DaysSinceLastSJ && $item->DaysSinceLastSJ < 9999) {
                        echo "   ✅ Akan tampil badge {$item->DaysSinceLastSJ} hari\n";
                    } else {
                        echo "   ❌ Akan tampil 'No Data'\n";
                    }
                    exit;
                }
            }
        } catch (\Exception $e) {
            echo "Error testing page {$page}: " . $e->getMessage() . "\n";
            break;
        }
    }
}

echo "\n=== SELESAI ===\n";