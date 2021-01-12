<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisGram extends Model
{
    use HasFactory;

    protected $table = 'jenis_gram';

    protected $fillable = [
        'kode',
        'nama',
        'jenisKertas',
        'gramKertas',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy',
    ];
}
