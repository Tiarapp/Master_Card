<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanBj extends Model
{
    use HasFactory;

    protected $connection = 'firebird2';
    protected $table = 'TPersediaan';

    public function barang() 
    {
        return $this->belongsTo(BarangJadi::class, 'KodeBrg', 'KodeBrg');
    }
}
