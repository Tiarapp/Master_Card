<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conv_D extends Model
{
    use HasFactory;

    protected $table = 'plan_conv_d';
    protected $fillable = [
        'opi_id',
        'plan_conv_m_id',
        'plan_corr_id',
        'tgl_kirim',
        'nomc',
        'nama_item',
        'customer',
        'tipe_order',
        'joint',
        'wax',
        'mesin',
        'sheet_p',
        'sheet_l',
        'flute',
        'bentuk',
        'warna',
        'out_flexo',
        'qtyOrder',
        'jml_plan',
        'ukuran_roll',
        'bungkus',
        'lain_lain',
        'rm_order',
        'tonase',
        'keterangan',
        'status',
        'lock',
        'urutan'
    ];

    public function convm()
    {
        return $this->belongsTo(Conv_M::class, 'plan_conv_m_id', 'id');
    }


    public function scopeConvd($query)
    {
        $query->leftJoin('plan_conv_m', 'plan_conv_m_id', 'plan_conv_m.id')
        ->leftJoin('hasil_plan_corr', 'plan_corr_id', 'hasil_plan_corr.id')
        ->leftJoin('opi_m', 'opi_id', 'opi_m.id')
        ->leftJoin('kontrak_d', 'opi_m.kontrak_d_id', 'kontrak_d.id')
        ->select('plan_conv_d.*', 'opi_m.NoOPI as noopi', 'kontrak_d.pcsKontrak')
        ->get();
    }
}
