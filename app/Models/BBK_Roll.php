<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BBK_Roll extends Model
{
    use HasFactory;

    protected $table = 'bbk_roll';

    protected $fillable = [
        'roll_d_id',
        'tgl_bbk',
        'No_OPI',
        'subs',
        'bbk',
        'created_by'
    ];

    public function rolld()
    {
        return $this->belongsTo(Roll_D::class);
    }
}
