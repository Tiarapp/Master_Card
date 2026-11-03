<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaletMutasiInternalDetail extends Model
{
    protected $table = 'palet_mutasi_internal_d';

    protected $fillable = [
        'palet_mutasi_internal_m_id',
        'item_palet_id',
        'qty',
    ];

    public function master(): BelongsTo
    {
        return $this->belongsTo(PaletMutasiInternal::class, 'palet_mutasi_internal_m_id');
    }

    public function palet(): BelongsTo
    {
        return $this->belongsTo(Palet::class, 'item_palet_id');
    }
}
