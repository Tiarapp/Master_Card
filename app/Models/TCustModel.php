<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCustModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $primaryKey = 'kode';
    protected $table = 'tcust';
    protected $fillable = [
        'kode',
        'nama',
        'alamat1',
        'alamat2',
        'kontak',
        'telp',
        'npwp',
        'lkredit',
        'umur',
    ];
}
