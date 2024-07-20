<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormMc extends Model
{
    use HasFactory;

    protected $table = 'form_mc';
    protected $primarykey = 'kode';
    protected $fillable = [
        'kode',
        'customer',
        'barang',
        'keterangan',
        'createdBy'
    ];
}
