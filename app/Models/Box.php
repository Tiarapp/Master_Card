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
        'nama',
        'tipebox_id',
        'tipeCreasCorr',
        'lebarSheetBox,',
        'panjangSheetBox',
        'tinggiSheetBox',
        'satuanSizeSheetBox',
        'luasSheetBox',
        'satuanLuasSheetBox',
        'gramSheetBox',
        'panjangDalamBox',
        'lebarDalamBox',
        'tinggiDalamBox',
        'satuanSizeDalamBox',
        'sizeCreasCorr',
        'sizeCreasConv',
        'satuanCreas',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedBy',
        'deletedAt',
    ];
}
