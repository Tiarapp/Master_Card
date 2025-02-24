<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangJadi extends Model
{
    use HasFactory;
    protected $connection = 'firebird2';
    protected $table = 'TBarangConv';
    protected $primary = 'KodeBrg';

    public function persediaan()
    {
        return $this->hasMany(PersediaanBj::class);
    }
}
