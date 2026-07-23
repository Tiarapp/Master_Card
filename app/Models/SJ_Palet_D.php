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

    public function scopeExportData($query, $startDate, $endDate)
    {
        $query->leftJoin('sj_palet_m', 'sj_palet_d.sj_palet_m_id', '=', 'sj_palet_m.id')
            ->leftJoin('item_palet', 'sj_palet_d.item_palet_id', '=', 'item_palet.id')
            ->select(
                'sj_palet_m.tanggal',
                'sj_palet_m.noSuratJalan',
                'sj_palet_m.namaCustomer',
                'sj_palet_m.noPolisi',
                'item_palet.nama as palet',
                'sj_palet_d.qty as quantity',
                'sj_palet_m.alamatCustomer'
            )
            ->whereBetween('sj_palet_m.tanggal', [$startDate, $endDate]);

        return $query;
    }
}
