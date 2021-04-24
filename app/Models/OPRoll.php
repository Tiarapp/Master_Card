<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPRoll extends Model
{
    use HasFactory;

    protected $table = 'opname_roll';

    protected $fillable = [
        'kode',
        'nama',
        'periode',
        'gudang',
        'saldo_akhir',
        'opname_kg',
        'opname_pcs',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy'
    ];
}
