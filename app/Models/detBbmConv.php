<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detBbmConv extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'fbbp';
    protected $table = 'TDetBBMConv';
    protected $primaryKey = 'NoUrut';
    protected $fillable = [
        'NoBBM',
        'KodeBrg',
        'NoOP',
        'NoOPB',
        'QtyP',
        'QtyS',
        'StockP',
        'StockS',
        'Harga',
        'NilaiKursRp',
        'NilaiKursUSD',
        'Discount',
        'BiayaLain',
        'Subtotal',
        'Keterangan',
        'HargaUSD'
    ];
}
