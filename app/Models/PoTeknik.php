<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoTeknik extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'fbteknik';
    protected $table = 'TOPTK';
    protected $primaryKey = 'NoOP';
    
}
