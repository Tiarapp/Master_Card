<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaletMutasi extends Model
{
    public const KELUAR = 'keluar';
    public const MASUK = 'masuk';

    protected $table = 'palet_mutasi';

    protected $fillable = [
        'tanggal',
        'jenis',
        'namaCustomer',
        'jenisPalet',
        'item_palet_id',
        'sj_palet_m_id',
        'qty',
        'qty_bagus',
        'qty_jelek',
        'noDokumen',
        'noPolisi',
        'keterangan',
        'createdBy',
        'lastUpdatedBy',
        'deletedAt',
        'deletedBy',
    ];

    public function palet(): BelongsTo
    {
        return $this->belongsTo(Palet::class, 'item_palet_id', 'id');
    }

    public function suratJalan(): BelongsTo
    {
        return $this->belongsTo(SJ_Palet_M::class, 'sj_palet_m_id', 'id');
    }

    public function scopeAktif($query)
    {
        return $query->whereNull('palet_mutasi.deletedAt');
    }
}
