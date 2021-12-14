<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilConv extends Model
{
    use HasFactory;

    protected $table = 'hasil_plan_conv';
    protected $fillable = [
        'plan_conv_m_id',
        'plan_conv_d_id',
        'noOpi',
        'mesin1',
        'mesin2',
        'mesin3',
        'mesin4',
        'mesin5',
        'mesin6',
        'jml_Order',
        'hasil_baik_mesin1',
        'hasil_jelek_mesin1',
        'hasil_baik_mesin2',
        'hasil_jelek_mesin2',
        'hasil_baik_mesin3',
        'hasil_jelek_mesin3',
        'hasil_baik_mesin4',
        'hasil_jelek_mesin4',
        'hasil_baik_mesin5',
        'hasil_jelek_mesin5',
        'hasil_baik_mesin6',
        'hasil_jelek_mesin6',
        'keterangan'
    ];

    public function scopeHasilconv($query)
    {
        $query->leftJoin('plan_conv_d', 'plan_conv_d_id', 'plan_conv_d.id')
        ->leftJoin('plan_conv_m', 'plan_conv_d.plan_conv_m_id', 'plan_conv_m.id')
        ->leftJoin('opi_m', 'plan_conv_d.opi_id', 'opi_m.id')
        ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', 'kontrak_m.id')
        ->leftJoin('mc', 'opi_m.mc_id', 'mc.id')
        ->leftJoin('dt', 'opi_m.dt_id', 'dt.id')
        ->select('hasil_plan_conv.*')
        ->groupBy('opi_m.id')
        ->get();
    }
}
