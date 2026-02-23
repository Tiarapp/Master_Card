<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_corr',
        'tanggal_produksi', 
        'shift',
        'revisi',
        'notes',
        'total_rm',
        'total_kg',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'tanggal_produksi',
        'deleted_at'
    ];

    public function user_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function details()
    {
        return $this->hasMany(CorrDetail::class, 'corr_master_id');
    }
}
