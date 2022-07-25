<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilConv extends Model
{
    use HasFactory;

    protected $table = 'hasil_plan_conv';
    protected $fillable = [
        'tanggal',
        'mesin',
        'noOpi',
        'hasil',        
        'keterangan'
    ];

    // public function scopeControl($query)
    // {
    //     $query->leftJoin('plan_conv_d', 'plan_conv_d_id', 'plan_conv_d.id')
    //     ->leftJoin('plan_conv_m', 'plan_conv_d.plan_conv_m_id', 'plan_conv_m.id')
    //     ->leftJoin('opi_m', 'plan_conv_d.opi_id', 'opi_m.id')
    //     ->leftJoin('plan_corr_d', 'plan_corr_d.opi_id', 'opi_m.id')
    //     ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
    //     ->leftJoin('mc', 'opi_m.mc_id', 'mc.id')
    //     ->leftJoin('dt', 'opi_m.dt_id', 'dt.id')
    //     ->select('hasil_plan_conv.*','hasil_plan_corr.*')
    //     ->groupBy('opi_m.id')
    //     ->get();
    // }
}