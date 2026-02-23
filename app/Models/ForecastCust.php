<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastCust extends Model
{
    use HasFactory;
    protected $table = 'forecast_custs';

    protected $fillable = [
        'customer_name',
        'sales_id',
        'bulan',
        'tahun',
        'target_tonase',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    // Relationship with Sales
    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    // Calculate realisasi from realisasi_kirim table
    public function getRealisasiAttribute()
    {
        return RealisasiKirim::whereHas('kontrakm', function($query) {
                $query->where('customer_name', 'LIKE', '%' . $this->customer_name . '%');
            })
            ->whereMonth('tanggal_kirim', $this->bulan)
            ->whereYear('tanggal_kirim', $this->tahun)
            ->sum('kg_kirim') / 1000; // Convert kg to ton
    }

    // Calculate intake from opi_m table
    public function getIntakeAttribute()
    {
        return Opi_M::whereHas('kontrakm', function($query) {
                $query->where('customer_name', 'LIKE', '%' . $this->customer_name . '%');
            })
            ->where('status_opi', '!=', 'CANCEL')
            ->whereMonth('tglKirimDt', $this->bulan)
            ->whereYear('tglKirimDt', $this->tahun)
            ->with(['mc'])
            ->get()
            ->sum(function($opi) {
                return ($opi->jumlahOrder * ($opi->mc->gramSheetBoxKontrak ?? 0)) / 1000; // Convert to ton
            });
    }

    // Relationship with Kontrak_M for intake calculation
    public function kontrakm()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_m_id');
    }

    // Relationship with MC for gram calculation
    public function mc()
    {
        return $this->belongsTo(Mastercard::class, 'mc_id');
    }


    
}
