<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorCombine extends Model
{
    use HasFactory;

    protected $table = 'color_combine';

    protected $fillable = [
        'kode',
        'nama',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy',
        'branch'
    ];
}
