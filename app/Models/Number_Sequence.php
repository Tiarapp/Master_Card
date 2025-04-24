<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number_Sequence extends Model
{
    use HasFactory;
    protected $table = 'number_sequence';
    protected $fillable = [
        'noBukti',
        'nomer',
    ];
}
