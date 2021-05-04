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
        // 'lebarSheetBox',
        // 'panjangSheetBox',
        // 'tinggiSheetBox',
        // 'luasSheetBox',
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
        // 'satuanCreas',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedBy',
        'deletedAt',
    ];
}
