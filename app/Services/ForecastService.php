<?php

namespace App\Services;

use App\Models\ForecastCust;
use App\Models\Opi_M;
use App\Models\RealisasiKirim;
use Illuminate\Support\Facades\DB;

class ForecastService
{
    public static function calculateMonthlyIntakeRealisasi($currentYear)
    {
        // Pre-calculate intake for all customers and months in one query
        $intakeData = Opi_M::select([
            'kontrak_m.customer_name',
            DB::raw('MONTH(opi_m.tglKirimDt) as bulan'),
            DB::raw('SUM(opi_m.jumlahOrder * (COALESCE(mc.gramSheetBoxKontrak, 0) / 1000)) as total_intake')
        ])
        ->join('kontrak_m', 'opi_m.kontrak_m_id', '=', 'kontrak_m.id')
        ->join('mc', 'opi_m.mc_id', '=', 'mc.id')
        ->where('opi_m.status_opi', '!=', 'CANCEL')
        ->whereYear('opi_m.tglKirimDt', $currentYear)
        ->whereNotNull('opi_m.tglKirimDt')
        ->groupBy('kontrak_m.customer_name', DB::raw('MONTH(opi_m.tglKirimDt)'))
        ->get()
        ->keyBy(function ($item) {
            return strtolower(trim($item->customer_name)) . '|' . $item->bulan;
        });

        // Pre-calculate realisasi for all customers and months in one query
        $realisasiData = RealisasiKirim::select([
            'kontrak_m.customer_name',
            DB::raw('MONTH(realisasi_kirim.tanggal_kirim) as bulan'),
            DB::raw('SUM(realisasi_kirim.kg_kirim / 1000) as total_realisasi')
        ])
        ->join('kontrak_m', 'realisasi_kirim.kontrak_m_id', '=', 'kontrak_m.id')
        ->whereYear('realisasi_kirim.tanggal_kirim', $currentYear)
        ->whereNotNull('realisasi_kirim.tanggal_kirim')
        ->groupBy('kontrak_m.customer_name', DB::raw('MONTH(realisasi_kirim.tanggal_kirim)'))
        ->get()
        ->keyBy(function ($item) {
            return strtolower(trim($item->customer_name)) . '|' . $item->bulan;
        });

        return [
            'intake' => $intakeData,
            'realisasi' => $realisasiData
        ];
    }

    public static function attachIntakeRealisasiData($forecasts, $intakeData, $realisasiData)
    {
        foreach ($forecasts as $forecast) {
            $key = strtolower(trim($forecast->customer_name)) . '|' . $forecast->bulan;
            
            // Set intake and realisasi from pre-calculated data
            $forecast->intake_calculated = $intakeData->get($key)->total_intake ?? 0;
            $forecast->realisasi_calculated = $realisasiData->get($key)->total_realisasi ?? 0;
        }

        return $forecasts;
    }
}