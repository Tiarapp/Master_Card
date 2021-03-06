<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palet extends Model
{
    use HasFactory;

    protected $table = 'item_palet';
    protected $fillable = [
        'nama',
        'kodePalet',
        'ukuran',
        'createdBy',
        'lastUpdatedBy',
        'deletedAt',
        'printedKe',
    ];
}
