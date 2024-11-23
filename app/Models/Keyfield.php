<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyfield extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'firebird2';
    protected $table = 'TKEYFIELD2';
    protected $primaryKey = 'Nama';
    protected $fillable = [
        'NoUrut'
    ];
}
