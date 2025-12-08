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
        'doubleJoint',
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
        'text',
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

    public function colorcombine()
    {
        return $this->belongsTo(ColorCombine::class, 'colorCombine_id', 'id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id', 'id');
    }

    public function substancekontrak()
    {
        return $this->belongsTo(Substance::class, 'substanceKontrak_id', 'id');
    }

    public function substanceproduksi()
    {
        return $this->belongsTo(Substance::class, 'substanceProduksi_id', 'id');
    }

    /**
     * CATATAN: Relasi ke DetPHP tidak bisa menggunakan Eloquent relationship 
     * karena berada di database yang berbeda (firebird2 vs default)
     * Gunakan method manual untuk mendapatkan data PHP
     */
    
    /**
     * Mendapatkan data PHP dari database firebird2 berdasarkan kodeBarang
     */
    public function getPhpData()
    {
        return DB::connection('firebird2')
            ->table('TDetPHP')
            ->where('KodeBrg', $this->kodeBarang)
            ->get();
    }

    /**
     * Mendapatkan total quantity PHP untuk mastercard ini
     */
    public function getTotalPhpQuantityAttribute()
    {
        return DB::connection('firebird2')
            ->table('TDetPHP')
            ->where('KodeBrg', $this->kodeBarang)
            ->sum(DB::raw('"Quantity"'));
    }

    /**
     * Scope untuk load mastercard dengan data PHP
     */
    public function scopeWithPhpData($query)
    {
        return $query->get()->map(function($mc) {
            $mc->php_data = $mc->getPhpData();
            $mc->total_php_quantity = $mc->total_php_quantity;
            return $mc;
        });
    }
}
