<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Mastercard;

class CrossDatabaseRelationService
{
    /**
     * Mendapatkan data mastercard dengan relasi PHP dari database berbeda
     * 
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getMastercardWithPhp($limit = 10)
    {
        try {
            // Ambil data mastercard
            $mastercards = Mastercard::take($limit)->get();
            
            // Ambil data PHP menggunakan raw SQL dengan TRIM untuk menghilangkan whitespace
            DB::connection('firebird2')->beginTransaction();
            $phpDataRaw = DB::connection('firebird2')
                ->select('SELECT TRIM(KodeBrg) as KodeBrg, SUM(Quantity) as totalBbm, COUNT(*) as total_records 
                         FROM TDetPHP 
                         GROUP BY TRIM(KodeBrg)');
            DB::connection('firebird2')->commit();
            
            // Convert ke collection dengan trim dan key by KODEBRG
            $phpData = collect($phpDataRaw)->map(function($item) {
                $item->KODEBRG = trim($item->KODEBRG ?? '');
                return $item;
            })->keyBy('KODEBRG');

            // Gabungkan data dengan trim kodeBarang
            return $mastercards->map(function($mc) use ($phpData) {
                $trimmedKodeBarang = trim($mc->kodeBarang ?? '');
                $phpRecord = $phpData->get($trimmedKodeBarang);
                
                $mc->php_data = $phpRecord ? [
                    'total_quantity' => $phpRecord->TOTALBBM,
                    'total_records' => $phpRecord->TOTAL_RECORDS,
                    'has_data' => true
                ] : [
                    'total_quantity' => 0,
                    'total_records' => 0,
                    'has_data' => false
                ];

                return $mc;
            });
            
        } catch (\Exception $e) {
            // Return empty collection on error
            return collect([]);
        }
    }

    /**
     * Mendapatkan data PHP dengan informasi mastercard
     * 
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getPhpWithMastercard($limit = 10)
    {
        try {
            // Ambil data PHP menggunakan raw SQL dengan TRIM
            DB::connection('firebird2')->beginTransaction();
            $phpDataRaw = DB::connection('firebird2')
                ->select('SELECT TRIM(KodeBrg) as KodeBrg, SUM(Quantity) as totalBbm 
                         FROM TDetPHP 
                         GROUP BY TRIM(KodeBrg) 
                         ROWS ' . $limit);
            DB::connection('firebird2')->commit();

            // Convert ke collection dengan trim
            $phpData = collect($phpDataRaw)->map(function($item) {
                $item->KODEBRG = trim($item->KODEBRG ?? '');
                return $item;
            });

            // Ambil kode-kode barang yang sudah di-trim
            $kodeBrgs = $phpData->pluck('KODEBRG');
            // Trim kodeBarang di mastercard juga untuk matching
            $mastercards = Mastercard::whereIn('kodeBarang', $kodeBrgs)
                ->get()
                ->mapWithKeys(function($mc) {
                    return [trim($mc->kodeBarang ?? '') => $mc];
                });

            // Gabungkan data
            return $phpData->map(function($php) use ($mastercards) {
                $mastercard = $mastercards->get($php->KODEBRG);
                
                return [
                    'kode_brg' => $php->KODEBRG,
                    'total_quantity' => $php->TOTALBBM,
                    'mastercard_data' => $mastercard ? [
                        'id' => $mastercard->id,
                        'kode' => $mastercard->kode,
                        'nama_barang' => $mastercard->namaBarang,
                        'customer' => $mastercard->customer,
                        'exists' => true
                    ] : [
                        'id' => null,
                        'kode' => null,
                        'nama_barang' => null,
                        'customer' => null,
                        'exists' => false
                    ]
                ];
            });
            
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Cari mastercard berdasarkan kode barang dengan data PHP
     * 
     * @param string $kodeBarang
     * @return array|null
     */
    public static function findMastercardWithPhp($kodeBarang)
    {
        try {
            $mastercard = Mastercard::where('kodeBarang', $kodeBarang)->first();
            
            if (!$mastercard) {
                return null;
            }

            // Gunakan raw SQL untuk Firebird
            DB::connection('firebird2')->beginTransaction();
            $phpDataRaw = DB::connection('firebird2')
                ->select('SELECT SUM(Quantity) as totalBbm, COUNT(*) as total_records 
                         FROM TDetPHP 
                         WHERE TRIM(KodeBrg) = ?', [trim($kodeBarang)]);
            DB::connection('firebird2')->commit();

            $phpData = count($phpDataRaw) > 0 ? $phpDataRaw[0] : null;

            return [
                'mastercard' => $mastercard,
                'php_data' => $phpData ? [
                    'total_quantity' => $phpData->TOTALBBM,
                    'total_records' => $phpData->TOTAL_RECORDS
                ] : null
            ];
            
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mendapatkan semua data PHP dalam bentuk cache untuk relasi cepat
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function getAllPhpDataCached()
    {
        try {
            DB::connection('firebird2')->beginTransaction();
            $phpDataRaw = DB::connection('firebird2')
                ->select('SELECT TRIM(KodeBrg) as KodeBrg, SUM(Quantity) as totalBbm, COUNT(*) as total_records, 
                         MIN(Tanggal) as first_date, MAX(Tanggal) as last_date
                         FROM TDetPHP 
                         GROUP BY TRIM(KodeBrg) 
                         ORDER BY totalBbm DESC');
            DB::connection('firebird2')->commit();

            return collect($phpDataRaw)->keyBy('KODEBRG');
            
        } catch (\Exception $e) {
            return collect([]);
        }
    }
}