<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbmTeknik extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'fbteknik';
    protected $table = 'TDetBBMTK';
    protected $primaryKey = 'NoUrut';
    
    public function po_teknik()
    {
        return $this->belongsTo(DetPoTeknik::class, 'NoOP', 'NoOP');
    }

    public function barang_teknik()
    {
        return $this->belongsTo(BarangTeknik::class, 'KodeBrg', 'KodeBrg');
    }
}
