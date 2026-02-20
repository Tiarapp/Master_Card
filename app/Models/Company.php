<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'logo'
    ];

    /**
     * Relationship with users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get company logo URL
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/companies/' . $this->logo) : null;
    }
}
