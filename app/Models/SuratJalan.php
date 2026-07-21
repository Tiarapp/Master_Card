<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'firebird2';
    protected $table = 'TSuratJalan';
    protected $primaryKey = 'NomerSJ';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NomerSJ',
        'Periode',
        'Tujuan',
        'TglSJ',
        'NamaCust',
        'NomerMOD',
        'Expedisi',
        'NoKend',
        'CaraAngkut',
        'NoSeal',
        'KodeCust',
        'KirimKe',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'Expedisi', 'Kode');
    }

    public function mod()
    {
        return $this->belongsTo(Mod::class, 'NomerMOD', 'NoBukti');
    }
}
