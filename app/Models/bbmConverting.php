<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bbmConverting extends Model
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
        'TglCetak',
        'KodeSupp',
        'TglJT',
        'KodeDept',
        'JenisBBM',
        'KodePerk',
        'Keterangan',
        'TotalBBM',
        'Print',
        'Aktif',
        'Blocked',
        'Posting'
    ];
}
