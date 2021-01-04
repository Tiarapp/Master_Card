<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataUang extends Model
{
    use HasFactory;

    protected $table = 'mata_uang';

    protected $fillable = [
        'kode',
        'nama',
        'createdBy',
        'lastUpdatedBy',
        'deletedAt',
        'deleted',
        'deletedBy',
        'branch'
    ];
}
