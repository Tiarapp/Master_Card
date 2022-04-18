<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll_M extends Model
{
    use HasFactory;

    protected $table = 'roll_m';
    protected $fillable = [
        'nama',
        'jenis',
        'gram',
        'lebar',
        'created_by'
    ];

    public function rollDetail()
    {
        return $this->hasMany(Roll_D::class, 'roll_m_id', 'id');
    }
}
