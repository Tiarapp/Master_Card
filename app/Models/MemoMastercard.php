<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoMastercard extends Model
{
    use HasFactory;
    protected $table = 'memo_mc';

    protected $fillable = [
        'id',
        'nomer',
        'tanggal',
        'customer',
        'barang',
        'keterangan',
        'created_by',
        'updated_by'
    ];
}
