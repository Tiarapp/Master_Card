<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiKaret extends Model
{
    use HasFactory;

    protected $table = 'alokasi_karets';
    protected $fillable = [
        'karet_id',
        'mc_id',
        'tanggal_kirim',
        'pcs',
        'alokasi_harga',
    ];

    public function karet()
    {
        return $this->belongsTo(Karet::class, 'karet_id');
    }

    public function mastercard()
    {
        return $this->belongsTo(Mastercard::class, 'mc_id');
    }
}
