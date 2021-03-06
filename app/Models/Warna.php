<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    use HasFactory;

    protected $table = 'color';

    protected $fillable = [
        'kode',
        'nama',
        'mudaTua',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedBy',
        'deletedAt',
        'branch'
    ];
}
