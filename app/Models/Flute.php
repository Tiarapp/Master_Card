<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flute extends Model
{
    use HasFactory;

    protected $table = 'flute';

    protected $fillable = [
        'kode',
        'nama',
        'tur',
        'createdBy',
        'lastUpdateBy',
        'deletedBy',
        'branch'
    ];
}
