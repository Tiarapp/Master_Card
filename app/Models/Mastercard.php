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
        'revisi',
        'namaBarang',
        'kodeBarang',
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
        'wax',
        'joint',
        'mesin',
        'outConv',
        'brt_kualitas',
        'flute',
        'berat_roll',
        'koli',
        'tipeMc',
        'gramSheetBoxKontrak',
        'gramSheetBoxProduksi',
        'gramSheetCorrKontrak',
        'gramSheetCorrProduksi',
        'gramSheetBoxKontrak2',
        'gramSheetBoxProduksi2',
        'gramSheetCorrKontrak2',
        'gramSheetCorrProduksi2',
        'bungkus',
        'lain',
        'keterangan',
        'gambar',
        'substanceKontrak_id',
        'substanceProduksi_id',
        'bom_m_id',
        'box_id',
        'colorCombine_id',
        'createdBy',
        'customer',
        'tipeCust',
        'luasSheetProd',
        'luasSheetBoxProd'
    ];
    
}
