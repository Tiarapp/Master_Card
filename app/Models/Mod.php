<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod extends Model
{
    use HasFactory;

    protected $connection = 'firebird2';
    protected $table = 'TMOD';
    protected $primaryKey = 'NoBukti';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'NoBukti',
        'Periode',
        'Tujuan',
        'TglOrder',
        'TglKirim',
        'KodeCustomer',
        'NamaCust',
        'KirimKe',
        'JenisOrder',
        'NomerPI_PO',
        'NomerSC',
    ];

    public function surat_jalan()
    {
        return $this->hasMany(SuratJalan::class, 'NomerMOD', 'NoBukti');
    }
}
