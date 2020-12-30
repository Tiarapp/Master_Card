<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'satuan';

    protected $fillable = [
        'kode',
        'nama',
        'branch',
        'createdBy',
        'lastUpdatedBy',
    ];
}
