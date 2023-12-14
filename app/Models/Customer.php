<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'f_tcustomer';
    protected $fillable = [
        'Kode', 
        'Nama',
        'NPWP',
        'AlamatKantor',
        'TelpKantor',
        'PIC',
        'AlamatKirim',
        'plafond',
        'top'
    ];
}
