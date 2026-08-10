<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclePhotos extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_load_id', 'photo_path', 'photo_type'];
}
