<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conv_M extends Model
{
    use HasFactory;

    protected $table = 'plan_conv_m';
    protected $fillable = [
        'kode',
        'shiftM',
        'tanggal',
        'revisi',
        'total_pcs',
        'total_kg',
    ];

    public function convd()
    {
        return $this->hasMany(Conv_D::class, 'plan_conv_m_id', 'id');
    }

    
    // public function scopeConvm($query)
    // {
        
    // }
}
