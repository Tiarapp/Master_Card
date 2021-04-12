<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPSheet extends Model
{
    use HasFactory;

    protected $table = 'opname_sheet';

    protected $fillable = [
        'id',
        'kode_barang',
        'nama',
        'gudang',
        'flute',
        'out',
        'periode',
        'opname_dm',
        'opname_pcs',
        'createdBy',
        'deletedBy',
        'lastUpdatedBy',
        'deletedAt',
    ];
}
