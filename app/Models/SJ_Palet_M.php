<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SJ_Palet_M extends Model
{
    use HasFactory;

    protected $table = 'sj_palet_m';
    protected $fillable = [
        'noSuratJalan',
        'tanggal',
        'noPolisi',
        'namaCustomer',
        'noPoCustomer',
        'alamatCustomer',
        'catatan',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy',
        'printedKe',
        'printedAt'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(SJ_Palet_D::class, 'sj_palet_m_id', 'id');
    }
}
