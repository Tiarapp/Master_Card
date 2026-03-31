<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKecil extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'tbKasKecil';

    public function kas_detail()
    {
        return $this->hasMany(KasKecilDet::class, 'Nomor', 'Nomor');
    }
}
