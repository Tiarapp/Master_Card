<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fbBarang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'firebird2';
    protected $table = 'TBarangConv';
    protected $primaryKey = 'KodeBrg';
    protected $fillable = [
        'KodeBrg',
        'KodeLama',
        'Eceran',
        'Tujuan',
        'TglKeluar',
        'JenisProd',
        'Merk',
        'Design',
        'WeightSheet',
        'Packing',
        'WeightValue',
        'Warna',
        'CustNick',
        'NamaBrg',
        'Satuan',
        'IsiPerKarton',
        'BeratStandart',
        'HargaJualRp',
        'HargaJualUSD',
        'BeratCRT'
    ];
}
