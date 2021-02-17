<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SJ_Palet_M extends Model
{
    use HasFactory;

    protected $table = 'sj_palet_m';
    protected $fillable = [
        'noSuratJalan',
        'tanggal',
        'noPolisi',
        'namaCustomer',
        'alamatCustomer',
        'catatan',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy',
        'printedKe',
        'printedAt'
    ];
}
