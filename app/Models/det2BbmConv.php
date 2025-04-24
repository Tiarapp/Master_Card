<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class det2BbmConv extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'fbbp';
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
