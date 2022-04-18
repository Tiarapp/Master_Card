<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur_BBK_Roll extends Model
{
    use HasFactory;
    protected $table = 'retur_bbk_roll';
    protected $fillable = [
        'roll_d_id',
        'tgl_retur',
        'qty_retur',
        'created_by'
    ];
}
