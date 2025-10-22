<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetPHP extends Model
{
    use HasFactory;

    protected $connection = 'firebird2';
    protected $table = 'TDetPHP';
    
    // Jika tidak ada primary key atau berbeda
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'KodeBrg',
        'Quantity'
    ];

    /**
     * Relasi ke Mastercard berdasarkan kode barang
     */
    public function mastercard()
    {
        return $this->belongsTo(Mastercard::class, 'KodeBrg', 'kodeBarang');
    }

    /**
     * Scope untuk aggregasi quantity
     */
    public function scopeWithTotalQuantity($query)
    {
        return $query->selectRaw('KodeBrg, SUM("Quantity") as totalBbm')
                    ->groupBy('KodeBrg');
    }
}