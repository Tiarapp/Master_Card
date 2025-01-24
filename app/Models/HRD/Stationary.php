<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stationary extends Model
{
    protected $connection = 'stationary';
    protected $table = 'TStationary';

    public function scopeBarang($query)
    {
        $periode = date('m/Y');
        $query->leftJoin('TPersediaan as a', 'a.KodeBrg', 'TStationary.KodeBrg')
            ->where('a.Periode', 'LIKE', $periode.'%')
            ->select('TStationary.KodeBrg', 'NamaBrg', 'Spesifikasi', 'a.Periode', 'a.SaldoAkhirP', 'a.SaldoAkhirS')
            ->get();
    }
}
