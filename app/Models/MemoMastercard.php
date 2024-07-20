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
        'tanggal',
        'customer',
        'barang',
        'keterangan'
    ];
}
