<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PersediaanBj extends Model
{
    use HasFactory;

    protected $connection = 'firebird2';
    protected $table = 'TPersediaan as a';

    public function barang() 
    {
        return $this->belongsTo(BarangJadi::class, 'KodeBrg', 'KodeBrg');
    }

    public function scopeExport($query, $periode)
    {
        return $query->leftJoin('TBarangConv as b', 'a.KodeBrg', '=', 'b.KodeBrg')
        ->select(
            'a.KodeBrg',
            'a.Periode',
            'b.NamaBrg',
            'b.BeratStandart',
            'a.SaldoAwalCrt',
            'a.SaldoAwalKg',
            DB::raw('"a"."ProduksiCrt" + "a"."BBMCrt" + "a"."ReturJualCrt" + "a"."RepackInCrt" as "MasukCrt"'),
            DB::raw('"a"."ProduksiKg" + "a"."BBMKg" + "a"."ReturJualKg" + "a"."RepackInKg" as "MasukKg"'),
            DB::raw('"a"."JualLokalCrt" + "a"."JualExportCrt" + "a"."SampleCrt" + "a"."BonusCrt" + "a"."RepackOutCrt" + "a"."RejectCrt" + "a"."ReturPembelianCrt" as "KeluarCrt"'),
            DB::raw('"a"."JualLokalKg" + "a"."JualExportKg" + "a"."SampleKg" + "a"."BonusKg" + "a"."RepackOutKg" + "a"."RejectKg" + "a"."ReturPembelianKg" as "KeluarKg"'),
            'a.AdjCRCrt',
            'a.AdjCRKg',
            'a.AdjDBCrt',
            'a.AdjDBKg',
            'a.SaldoAkhirCrt',
            'a.SaldoAkhirKg'
        )
        ->where('a.Periode', $periode)
        ->whereRaw('(
            (COALESCE("a"."SaldoAwalCrt", 0) +COALESCE("a"."ProduksiCrt", 0) + COALESCE("a"."BBMCrt", 0) + COALESCE("a"."ReturJualCrt", 0) + COALESCE("a"."RepackInCrt", 0) +
             COALESCE("a"."SaldoAwalKg", 0) + COALESCE("a"."ProduksiKg", 0) + COALESCE("a"."BBMKg", 0) + COALESCE("a"."ReturJualKg", 0) + COALESCE("a"."RepackInKg", 0) +
             COALESCE("a"."JualLokalCrt", 0) + COALESCE("a"."JualExportCrt", 0) + COALESCE("a"."SampleCrt", 0) + COALESCE("a"."BonusCrt", 0) +
             COALESCE("a"."SaldoAkhirCrt", 0) + COALESCE("a"."RepackOutCrt", 0) + COALESCE("a"."RejectCrt", 0) + COALESCE("a"."ReturPembelianCrt", 0) +
             COALESCE("a"."JualLokalKg", 0) + COALESCE("a"."JualExportKg", 0) + COALESCE("a"."SampleKg", 0) + COALESCE("a"."BonusKg", 0) +
             COALESCE("a"."SaldoAkhirKg", 0) + COALESCE("a"."RepackOutKg", 0) + COALESCE("a"."RejectKg", 0) + COALESCE("a"."ReturPembelianKg", 0)
            ) <> 0
        )')
        ->orderBy('a.KodeBrg');
    }
}
