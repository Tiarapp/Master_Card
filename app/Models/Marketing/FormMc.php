<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMc extends Model
{
    use HasFactory;

    protected $table = 'form_mc';
    protected $primaryKey = 'kode';
    protected $casts = [
        'kode' => 'string',
        'customer' => 'string',
        'barang' => 'string',
        'keterangan' => 'string'
    ];
    protected $fillable = [
        'kode',
        'customer',
        'barang',
        'keterangan',
        'createdBy'
    ];
}
