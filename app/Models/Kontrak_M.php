<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak_M extends Model
{
    use HasFactory;

    protected $table = 'kontrak_m';
    protected $fillable = [
        'kode',
        'mc_id',
        'tglKontrak',
        'customer_name',
        'poCustomer',
        'top',
        'caraKirim',
        'alamatKirim',
        'alamatKantor',
        'alamatTagihan',
        'alamatKirim_id',
        'alamatKantor_id',
        'alamatTagihan_id',
        'pcsKontrak',
        'pctToleransiLebihKontrak',
        'pctToleransiKurangKontrak',
        'kgLebihToleransiKontrak',
        'pctKurangToleransiKontrak',
        'pcsLebihToleransiKontrak',
        'pcsKurangToleransiKontrak',
        'kgKurangToleransiKontrak',
        'kgKontrak',
        'amountBeforeTax',
        'tax',
        'amountTotal',
        'rpKg',
        'sisaPlafon',
        'pcsSisaKontrak',
        'kgSisaKontrak',
        'status',
        'lock',
        'sales',
        'harga',
        'keterangan',
        'createdBy'
    ];

    // Relasi one to Many

    public function kontrak_d()
    {
        return $this->hasMany(Kontrak_D::class, 'kontrak_m_id', 'id');
    }

    public function DeliveryTime()
    {
        return $this->hasMany(DeliveryTime::class, 'kontrak_m_id', 'id');
    }
}
