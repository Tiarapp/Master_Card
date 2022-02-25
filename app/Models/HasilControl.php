<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilControl extends Model
{
    use HasFactory;

    protected $table = 'hasil_produksi';
    protected $fillable = [
        'opi_id',
        'noOpi',
        'corr',
        'flexo',
        'tokai',
        'stitch',
        'wax',
        'slitter',
        'glue_manual',
        'stb',
        'jml_Order',
        'tgl_corr',
        'hasil_baik_corr',
        'hasil_jelek_corr',
        'tgl_flexo',
        'hasil_baik_flexo',
        'hasil_jelek_flexo',
        'tgl_tokai',
        'hasil_baik_tokai',
        'hasil_jelek_tokai',
        'tgl_stitch',
        'hasil_baik_stitch',
        'hasil_jelek_stitch',
        'tgl_wax',
        'hasil_baik_wax',
        'hasil_jelek_wax',
        'tgl_slitter',
        'hasil_baik_slitter',
        'hasil_jelek_slitter',
        'tgl_glue',
        'hasil_baik_glue',
        'hasil_jelek_glue',
        'tgl_stb',
        'hasil_baik_stb',
        'hasil_jelek_stb',
    ];
}
