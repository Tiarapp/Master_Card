<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mastercard extends Model
{
    use HasFactory;

    protected $table = 'mc';

    protected $fillable = [
        'kode',
        'bj_id',
        'tipeBox_id',
        'subtanceSheet_id',
        'wax_id',
        'joint_id',
        'mesin',
        'outConv',
        'flute_id',
        'koli_id',
        'bungkus',
        'keterangan',
        'gambar',
        'substanceKontrak_id',
        'substanceProduksi_id',
        'bom_m_id',
        'box_id',
        'colorCombine_id',
    ];
}
