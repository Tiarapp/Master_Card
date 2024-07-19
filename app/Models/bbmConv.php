<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bbmConv extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'fbbp';
    protected $table = 'TBBMConv';
    protected $primaryKey = 'NoBukti';
    protected $fillable = [
        'NoBukti',
        'Periode',
        'TglMasuk',
        'KodeSupp',
        'TglJT',
        'JenisBBM',
        'Keterangan',
        'TotalBBM',
        'Print',
        'Aktif'
    ];
}
