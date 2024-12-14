<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SJ_Palet_D extends Model
{
    use HasFactory;

    protected $table = 'sj_palet_d';

    protected $fillable = [
        'sj_palet_m_id',
        'item_palet_id',
        'qty',
        'namaBarang',
        'ukuran',
        'noKontrak',
        'keterangan',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy',
        'printedKe',
        'printedAt'
    ];

    public function master_palet(): BelongsTo
    {
        return $this->belongsTo(SJ_Palet_M::class, 'sj_palet_m_id', 'id');
    }
}
