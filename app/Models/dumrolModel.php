<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dumrolModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'dumrol';
    protected $primaryKey = 'urut';
    protected $fillable = [
        'nomer',
        'tanggal',
        'kode',
        'nama',
        'barang',
        'ukuran',
        'kwalitas',
        'terima',
        'terima2',
        'noroll',
        'noroll2',
        'supplier'
    ];
}
