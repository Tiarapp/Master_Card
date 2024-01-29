<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkspedisiModel extends Model
{
    use HasFactory;    
    protected $connection = 'mysql2';
    protected $primaryKey = 'kode';
    protected $table = 'texpedisi';
    protected $fillable = [
        'kode',
        'expedisi'
    ];
}
