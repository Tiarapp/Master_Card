<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mastercard extends Model
{
    use HasFactory;

    protected $table = 'mc';

    protected $fillable = [
        'kode',
        'bj_id',
        'tipebox',
        'CreasCorrP',
        'CreasCorrL',
        'lebarSheet',
        'panjangSheet',
        'luasSheet',
        'lebarSheetBox',
        'panjangSheetBox',
        'luasSheetBox',
        'subtanceSheet_id',
        'wax_id',
        'joint',
        'mesin',
        'outConv',
        'flute',
        'koli',
        'gramSheetBox',
        'gramSheetCorrKontrak',
        'gramSheetCorrProduksi',
        'bungkus',
        'keterangan',
        'gambar',
        'substanceKontrak_id',
        'substanceProduksi_id',
        'bom_m_id',
        'box_id',
        'colorCombine_id',
        'createdBy'
    ];
    
}
