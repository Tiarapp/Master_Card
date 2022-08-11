<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilProduksi extends Model
{
    use HasFactory;

    protected $table = 'hasil_produksi';

    protected $fillable = [
        'opi_id',
        'noOpi',
        'start_date',
        'end_date',
        'hasil_baik',
        'tonase_baik',
        'hasil_jelek',
        'tonase_jelek',
        'mesin',
        'keterangan',
        'downtime',
        'durasi'
    ];

}
