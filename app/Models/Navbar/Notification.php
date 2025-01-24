<?php

namespace App\Models\Navbar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';
    protected $fillable = [
        'kode',
        'alasan',
        'tanggal',
        'pemohon',
        'status',
        'pic'
    ];
}
