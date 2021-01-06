<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxType extends Model
{
    use HasFactory;

    protected $table = 'tipe_box';

    protected $fillable = [
        'kode',
        'nama',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedBy',
        'deletedAt',
        'branch'
    ];
}
