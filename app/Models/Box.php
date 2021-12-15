<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $table = 'box';

    protected $fillable =[
        'kode',
        'kodeBarang',
        'namaBarang',
        'tipebox',
        'flute',
        'tipeCreasCorr',
        'kuping2',
        'panjangDalamBox',
        'lebarDalamBox',
        'tinggiDalamBox',
        'sizeCreasCorr',
        'sizeCreasConv',
        'kuping',
        'panjangCrease',
        'lebarCrease1',
        'lebarCrease2',
        'flapCrease',
        'tinggiCrease',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedBy',
        'deletedAt',
    ];
}
