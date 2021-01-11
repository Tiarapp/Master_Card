<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    protected $table = 'sheet';

    protected $fillable = [
        'kode',
        'nama',
        'lebarSheet',
        'panjangSheet',
        'satuanSizeSheet',
        'luasSheet',
        'satuanLuasSheet',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy',
    ];
}
