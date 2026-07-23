<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SJ extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'firebird2';
    protected $table = 'TSuratJalanBackup';
    protected $primaryKey = 'NomerSJ';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'NomerSJ'
    ];
}
