<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKecilDet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'tbKasKecil_Detail';

    public function kasKecil()
    {
        return $this->belongsTo(KasKecil::class, 'Nomor', 'Nomor');
    }

    public function coa()
    {
        return $this->belongsTo(COA::class, 'COA', 'kd_coa');
    }
}
