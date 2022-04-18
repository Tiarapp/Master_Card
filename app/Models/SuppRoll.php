<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppRoll extends Model
{
    use HasFactory;

    protected $table = 'master_supp';

    protected $fillable = [
        'kode_supp',
        'name',
        'numb_seq',
        'created_by'
    ];

    public function rolld()
    {
        return $this->hasMany(Roll_D::class, 'roll_d_id', 'id');
    }
}
