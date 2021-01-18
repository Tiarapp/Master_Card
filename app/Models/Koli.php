<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koli extends Model
{
    use HasFactory;
    
    protected $table = 'koli';
    protected $fillable = [
        'kode',
        'nama',
        'qtyBox',
        'satuanBox',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy'
    ];
}
