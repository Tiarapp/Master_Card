<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BbkRoll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bbk_number',
        'inventory_id',
        'tanggal_bbk',
        'keluar',
        'kembali',
        'opi',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
