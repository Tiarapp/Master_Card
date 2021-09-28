<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corr_M extends Model
{
    use HasFactory;

    protected $table = 'plan_corr_m';
    protected $fillable = [
        'kode_plan', 
        'tanggal',
        'shift',
        'revisi',
        'total_RM',
        'total_Berat'
    ];

    public function corrd()
    {
        return $this->hasMany(Corr_D::class, 'plan_corr_m_id', 'id');
    }

}
