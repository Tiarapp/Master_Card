<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDowntime extends Model
{
    use HasFactory;
    protected $table = 'jenis_downtime';

    protected $fillable = [
        'mesin_id',
        'downtime',
        'pic',
        'allowedMinute',
        'createdBy',
        'lastUpdateBy',
        'deletedAt',
        'deletedBy',
        'printedKe',
        'printedAt',
        'branch'
    ];
}