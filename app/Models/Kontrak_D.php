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
        'harga_pcs',
        'amountBeforeTax',
        'ppn',
        'tax',
        'amountTotal',
        'harga_kg',
        'createdBy',
        'lastUpdatedBy',
        'deletedBy',
        'deletedAt',
        'printedKe',
        'printedAt'
    ];

    
    public function mc()
    {
        return $this->belongsTo(Mastercard::class, 'mc_id', 'id');
    }

    public function kontrakm()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_m_id', 'id');
    }

}
