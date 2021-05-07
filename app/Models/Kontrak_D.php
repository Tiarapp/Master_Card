<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak_D extends Model
{
    use HasFactory;

    protected $table = 'kontrak_d';
    protected $fillable = [
        'kontrak_m_id',
        'mc_id',
        'tipe',
        'pcsKontrak',
        'kgKontrak',
        'pcsSisaKontrak',
        'kgSisaKontrak',
        'pctToleransiLebihKontrak',
        'pctToleransiKurangKontrak',
        'pcsKurangToleransiKontrak',
        'kgKurangToleransiKontrak',
        'pcsLebihToleransiKontrak',
        'kgLebihToleransiKontrak',
        'harga',
        'amountBeforeTax',
        'ppn',
        'tax',
        'amountTotal',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy',
        'deletedAt',
        'printedKe',
        'printedAt'
    ];
}
