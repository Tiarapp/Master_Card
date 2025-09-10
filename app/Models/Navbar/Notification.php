<?php

namespace App\Models\Navbar;

use App\Models\Kontrak_M;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';
    public $timestamps = true; // Enable timestamps
    protected $fillable = [
        'kontrak_id',
        'alasan',
        'tanggal',
        'pemohon',
        'status',
        'pic',
        'created_at',
        'updated_at'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak_M::class, 'kontrak_id', 'id');
    }
}
