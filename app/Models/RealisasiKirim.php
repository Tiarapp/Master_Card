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
        'opi_id',
        'nomer_sj',
        'mod',
        'tanggal_kirim',
        'qty_kirim',
        'kg_kirim',
        'createdBy'
    ];

    public function kontrakm()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_m_id');
    }

    public function opi()
    {
        return $this->belongsTo(Opi_M::class, 'opi_id');
    }
}
