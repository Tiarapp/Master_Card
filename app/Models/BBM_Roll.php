<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BBM_Roll extends Model
{
    use HasFactory;
    protected $table = 'bbm_roll';
    protected $fillable = [
        'roll_d_id',
        'tgl_bbm',
        'berat_sj',
        'berat_timbang',
        'no_po',
        'created_by'
    ];

    public function rolld()
    {
        return $this->belongsTo(Roll_D::class, 'roll_d_id', 'id');
    }
}
