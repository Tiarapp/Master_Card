<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    use HasFactory;

    protected $table = 'substance';

    protected $fillable = [
        'kode',
        'nama',
        'flute',
        'jenisGramLinerAtas_id',
        'jenisGramFlute1_id',
        'jenisGramLinerTengah_id',
        'jenisGramFlute2_id',
        'jenisGramLinerBawah_id',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy',
    ];
}
