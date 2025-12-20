<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'corr_master_id',
        'opi_id',
        'mc_id',
        'urutan',
        'sheet_p',
        'sheet_l',
        'order_qty',
        'out_flx',
        'plan_plus',
        'plan_min',
        'out_corr',
        'lebar_roll',
        'trim_waste',
        'cop_plus',
        'cop_min',
        'jenis_kertas1',
        'gram_kertas1',
        'kebutuhan_kertas1',
        'jenis_kertas2',
        'gram_kertas2',
        'kebutuhan_kertas2',
        'jenis_kertas3',
        'gram_kertas3',
        'kebutuhan_kertas3',
        'jenis_kertas4',
        'gram_kertas4',
        'kebutuhan_kertas4',
        'jenis_kertas5',
        'gram_kertas5',
        'kebutuhan_kertas5',
        'rm_total',
        'kg_total',
        'keterangan'
    ];

    public function corrMaster()
    {
        return $this->belongsTo(CorrMaster::class, 'corr_master_id');
    }

    public function opi()
    {
        return $this->belongsTo(Opi_M::class, 'opi_id');
    }


}
