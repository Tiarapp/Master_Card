<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiKirim extends Model
{
    use HasFactory;

    protected $table = 'realisasi_kirim';
    protected $fillable =[
        'kontrak_m_id',
        'tanggal_kirim',
        'qty_kirim',
        'createdBy'
    ];
}
