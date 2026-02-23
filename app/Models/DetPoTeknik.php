<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetPoTeknik extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'fbteknik';
    protected $table = 'TDetOPTK';
    protected $primaryKey = 'NoUrut';

    public function po_master()
    {
        return $this->belongsTo(PoTeknik::class, 'NoOP', 'NoOP');
    }
}
