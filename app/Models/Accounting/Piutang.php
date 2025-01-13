<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'TPiutang';
    protected $fillable = [
        'NoBukti',
        'NoRef',
        'Note',
        'JTrans',
        'Jenis',
        'JenisDK',
        'Periode',
        'Tanggal',
        'TglJT',
        'KodeCust',
        'NamaCust',
        'KodeGroupCust',
        'GroupCust',
        'KdPerkiraan',
        'MataUang',
        'NilaiKurs',
        'Total',
        'TotalTerima',
        'Penjualan',
        'PPN',
        'PPH',
        'SJINV',
        'KdDept',
        'External'
    ];
}
