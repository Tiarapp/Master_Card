<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetBBM extends Model
{
    use HasFactory;

    protected $connection = 'firebird4';
    protected $primaryKey = 'NoUrut';
    protected $table = 'TDet2BBM';
    protected $fillable = [
        'NoUrut',
        'NomerBBM',
        'KodeBrg',
        'KodeRoll',
        'BrtRew',
        'BrtWrapping',
        'NOBBK'
    ];

}
