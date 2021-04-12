<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPBJ extends Model
{
    use HasFactory;

    protected $table = 'opname_bj';

    protected $fillable = [
        'kode',
        'nama',
        'periode',
        'opname_koli',
        'opname_pcs',
        'per_koli',
        'gudang',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy'
    ];
}
