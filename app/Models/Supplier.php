<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'f_tsupplier';

    protected $fillable = [
        'Kode',
        'Nama',
        'KodeNamaAcc',
        'NamaAcc',
        'AlamatKantor',
        'KotaKantor',
        'TelpKantor',
        'FaxKantor',
        'PIC',
        'TelpPIC',
        'Plafond',
        'WaktuBayar',
        'JenisBayar',
        'Area',
        'NPWP',
        'NPPKP',
        'Bank',
        'NoAcc',
        'NamaRek'
    ];
}
