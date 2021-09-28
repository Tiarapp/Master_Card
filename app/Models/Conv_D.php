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
        'lock'
    ];

    public function convm()
    {
        return $this->belongsTo(Conv_M::class, 'plan_conv_m_id', 'id');
    }
}
