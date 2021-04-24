<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPTeknik extends Model
{
    use HasFactory;

    protected $table = 'opname_teknik';

    protected $fillable = [
        'kode',
        'nama',
        'periode',
        'satuan',
        'saldo_akhir',
        'opname',
        'createdBy',
        'lastUpdatedBy'
    ];
}
