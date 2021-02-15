<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
