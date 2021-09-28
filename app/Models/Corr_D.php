<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corr_D extends Model
{
    use HasFactory;
    protected $table = 'plan_corr_d';

    protected $fillable = [
        'opi_id',
        'plan_corr_m_id',
        'kode_plan_d',
        'sheet_p',
        'sheet_l',
        'flute',
        'bentuk',
        'out_corr',
        'out_flexo',
        'qtyOrder',
        'ukuran_roll',
        'cop',
        'trim_waste',
        'rm_order',
        'tonase',
        'kebutuhan_kertasAtas',
        'kebutuhan_kertasFlute1',
        'kebutuhan_kertasTengah',
        'kebutuhan_kertasFlute2',
        'kebutuhan_kertasBawah',
        'keterangan',
        'status',
        'lock',
        'urutan'
    ];

    public function corrm()
    {
        return $this->belongsTo(Corr_M::class, 'plan_corr_m_id','id');
    }

    public function scopeCorr($query)
    {
        $query->rightJoin('plan_corr_m', 'plan_corr_m_id', 'plan_corr_m.id')
        ->rightJoin('opi_m', 'opi_id', 'opi_m.id')
        ->select('plan_corr_d.*','opi_m.id as opi_id', 'plan_corr_m.id', 'plan_corr_m.kode_plan as kodeplanM', 'plan_corr_m.tanggal as tglcorr', 'plan_corr_m.shift', 'plan_corr_m.revisi', 'plan_corr_m.total_RM', 'plan_corr_m.total_Berat')
        ->where('plan_corr_d.id', '!=', 'null')
        ->get();


        return $query;
    }
}
