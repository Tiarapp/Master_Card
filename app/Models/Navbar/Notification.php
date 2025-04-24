<?php

namespace App\Models\Navbar;

use App\Models\Kontrak_M;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';
    protected $fillable = [
        'kontrak_id',
        'alasan',
        'tanggal',
        'pemohon',
        'status',
        'pic'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_id', 'id');
    }
}
