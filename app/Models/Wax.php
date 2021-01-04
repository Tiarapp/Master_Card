<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wax extends Model
{
    use HasFactory;

    protected $table = 'wax';

    protected $fillable = [
        'kode',
        'nama',
        'luas',
        'inOut',
        'satuanLuas',
        'gramWax',
        'satuanGramWax',
        'avgPrice',
        'mataUang',
        'createdBy',
        'lastUpdatedBy',
        'branch',
        'deleted',
        'deletedBy',
        'deletedAt'
    ];
}
