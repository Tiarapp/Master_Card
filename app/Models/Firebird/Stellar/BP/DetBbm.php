<?php

namespace App\Models\Firebird\Stellar\BP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetBbm extends Model
{
    use HasFactory;
    protected $connection = 'stellar_bp';
    protected $table = 'TDetBBMConv';

    public function master_bbm()
    {
        return $this->belongsTo(Bbm::class, 'NoBBM', 'NoBukti');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'KodeBrg', 'KodeBrg');
    }
}
