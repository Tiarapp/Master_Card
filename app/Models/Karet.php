<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karet extends Model
{
    use HasFactory;

    protected $table = 'karets';

    protected $fillable = [
        'mc_id',
        'customer',
        'sales_name',
        'kode_barang',
        'nama_karet',
        'no_po',
        'gsm',
        'harga_per_kg',
        'lokasi_kirim',
        'tanggal_masuk',
        'harga',
        'tipe',
        'bbm_id',
        'alokasi',
        'sisa',
    ];

    public function mastercard()
    {
        return $this->belongsTo(Mastercard::class, 'mc_id');
    }

    public function alokasiKarets()
    {
        return $this->hasMany(AlokasiKaret::class, 'karet_id');
    }
}
