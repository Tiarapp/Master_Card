<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joint extends Model
{
    use HasFactory;

    protected $table = 'joint';

    protected $fillable = [
        'kode',
        'nama',
        'qtyJoint',
        'satuanJoint',
        'avgPrice',
        'mataUang',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy',
        'branch'
    ];
}
