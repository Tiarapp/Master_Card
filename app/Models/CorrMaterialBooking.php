<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrMaterialBooking extends Model
{
    use HasFactory;

    const STATUS_BOOKED = 'BOOKED';
    const STATUS_RELEASED = 'RELEASED';
    const STATUS_ISSUED = 'ISSUED';
    const STATUS_CANCELLED = 'CANCELLED';

    protected $fillable = [
        'corr_material_requirement_id', 'inventory_id', 'qty_booked', 'status',
        'booked_at', 'released_at', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'qty_booked' => 'float',
        'booked_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function requirement()
    {
        return $this->belongsTo(CorrMaterialRequirement::class, 'corr_material_requirement_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_BOOKED);
    }
}
