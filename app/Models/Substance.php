<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    use HasFactory;

    protected $table = 'substance';

    protected $fillable = [
        'kode',
        'namaMc',
        'namaLog',
        'flute',
        'jenisGramLinerAtas_id',
        'jenisGramFlute1_id',
        'jenisGramLinerTengah_id',
        'jenisGramFlute2_id',
        'jenisGramLinerBawah_id',
        'createdBy',
        'lastUpdatedBy',
        'deleted',
        'deletedAt',
        'deletedBy',
    ];

    public function lineratas()
    {
        return $this->belongsTo(JenisGram::class, 'jenisGramLinerAtas_id', 'id');
    }

    public function flute1()
    {
        return $this->belongsTo(JenisGram::class, 'jenisGramFlute1_id', 'id');
    }

    public function linertengah()
    {
        return $this->belongsTo(JenisGram::class, 'jenisGramLinerTengah_id', 'id');
    }

    public function flute2()
    {
        return $this->belongsTo(JenisGram::class, 'jenisGramFlute2_id', 'id');
    }

    public function linerbawah()
    {
        return $this->belongsTo(JenisGram::class, 'jenisGramLinerBawah_id', 'id');
    }

}
