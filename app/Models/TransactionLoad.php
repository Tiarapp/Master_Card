<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLoad extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_name',
        'vehicle_number',
        'masterdata_id',
        'destination',
        'type',
        'status',
        'status_load',
        'date_in',
        'date_out',
    ];

    public function masterdata()
    {
        return $this->belongsTo(Masterdata::class, 'masterdata_id');
    }
}
