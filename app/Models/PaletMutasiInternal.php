<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaletMutasiInternal extends Model
{
    protected $table = 'palet_mutasi_internal_m';

    protected $fillable = [
        'tanggal',
        'sumber',
        'createdBy',
        'lastUpdatedBy',
        'deletedAt',
        'deletedBy',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(PaletMutasiInternalDetail::class, 'palet_mutasi_internal_m_id');
    }

    public function scopeAktif($query)
    {
        return $query->whereNull('palet_mutasi_internal_m.deletedAt');
    }
}
