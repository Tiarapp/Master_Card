<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrMaterialRequirement extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'PENDING';
    const STATUS_PARTIAL = 'PARTIAL';
    const STATUS_FULLY_BOOKED = 'FULLY_BOOKED';

    protected $fillable = [
        'corr_detail_id', 'layer_no', 'jenis', 'gsm', 'lebar_roll', 'qty_required',
        'qty_booked', 'status'
    ];

    protected $casts = [
        'qty_required' => 'float',
        'qty_booked' => 'float',
    ];

    public function corrDetail()
    {
        return $this->belongsTo(CorrDetail::class, 'corr_detail_id');
    }

    public function bookings()
    {
        return $this->hasMany(CorrMaterialBooking::class);
    }

    public function getRemainingAttribute()
    {
        return max(0, (float) $this->qty_required - (float) $this->qty_booked);
    }
}
