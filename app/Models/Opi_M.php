<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opi_M extends Model
{
    use HasFactory;

    protected $table = 'opi_m';
    protected $fillable = [
        'NoOPI',
        'nama',
        'mc_id',
        'dt_id',
        'tglKirimDt',
        'pcsDt',
        'kgDt',
        'hariKirimDt',
        'kontrak_m_id',
        'kontrak_d_id',
        'keterangan',
        'jumlahOrder',
        'createdBy',
        'lastUpdatedBy',
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_m_id', 'id');
    }
}
