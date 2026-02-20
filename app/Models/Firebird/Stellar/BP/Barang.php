<?php

namespace App\Models\Firebird\Stellar\BP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $connection = 'stellar_bp';
    protected $table = 'TBarang';
    
}
