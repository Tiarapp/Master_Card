<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak_M extends Model
{
    use HasFactory;

    protected $table = 'kontrak_m';
    protected $fillable = [
        'kode',
        'mc_id',
        'tglKontrak',
        'customer_id',
        'poCustomer',
        'top_id',
        'caraKirim',
        'alamat'
    ];
}
