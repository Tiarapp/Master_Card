<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll_D extends Model
{
    use HasFactory;

    protected $table = 'roll_d';
    protected $fillable = [
        'kode_roll',
        'roll_m_id',
        'supp_id',
        'kode_internal',
        'gsm_actual',
        'cobsize_top',
        'cobsize_back',
        'stok',
        'is_edit',
        'created_by'
    ];

    public function rollMaster()
    {
        return $this->belongsTo(Roll_M::class, 'roll_m_id', 'id');
    }

    public function supp()
    {
        return $this->belongsTo(SuppRoll::class, 'supp_id', 'id');
    }

    public function bbm()
    {
        return $this->hasOne(BBM_Roll::class, 'roll_d_id', 'id');
    }

    public function bbk()
    {
        return $this->hasMany(BBK_Roll::class, 'roll_d_id', 'id');
    }

    public function returbbk()
    {
        return $this->hasMany(Retur_BBK_Roll::class, 'roll_d_id', 'id');
    }
}
