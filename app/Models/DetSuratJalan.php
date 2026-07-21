<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetSuratJalan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'firebird2';
    protected $table = 'TDetSJ';
    protected $primaryKey = 'NoUrut';
    public $incrementing = false;

    protected $fillable = [
        'NomerSJ',
        'NoUrut',
        'KodeBrg',
        'Quantity',
        'HargaAwal',
        'SubTotalAwalSblmPPN',
        'PPN',
        'SubTotalAkhir',
    ];

    public function surat_jalan()
    {
        return $this->belongsTo(SuratJalan::class, 'NomerSJ', 'NomerSJ');
    }

    public function barang()
    {
        return $this->belongsTo(BarangJadi::class, 'KodeBrg', 'KodeBrg');
    }

    public function scopeExportDetail($query, $tgl_awal, $tgl_akhir)
    {
        return $query->leftJoin('TBarangConv as barang', 'TDetSJ.KodeBrg', '=', 'barang.KodeBrg')
            ->leftJoin('TSuratJalan as sj', 'TDetSJ.NomerSJ', '=', 'sj.NomerSJ')
            ->leftJoin('TMOD', 'sj.NomerMOD', '=', 'TMOD.NoBukti')
            ->select(
                'TDetSJ.NomerSJ',
                'TDetSJ.KodeBrg',
                'barang.NamaBrg',
                'TDetSJ.Quantity',
                'sj.TglSJ',
                'TMOD.NomerSC',
                'TMOD.NomerPI_PO',
                'TMOD.JenisOrder',
                'sj.NamaCust',
                'sj.Expedisi',
                'sj.NoKend',
                'sj.CaraAngkut',
                'sj.NoSeal',
                'sj.Tujuan',
                'sj.KodeCust',
                'sj.KirimKe',
                'sj.NomerMOD',
                'barang.BeratStandart'
            )
            ->whereBetween('sj.TglSJ', [$tgl_awal, $tgl_akhir])
            ->orderBy('sj.TglSJ', 'desc');
    }
}
