<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcModel extends Model
{
    use HasFactory;

    protected $table = 'testqc';
    protected $fillable = [
        'tanggal_analisa',
        'opi_id',
        'mc',
        'cust',
        'item',
        'kwalitas',
        'no_po',
        'no_analisa',
        'no_batch',
        'jumlah_kirim',
        'tanggal_kirim',
        'berat1',
        'berat2',
        'berat3',
        'berat4',
        'berat5',
        'avg_berat',
        'bst1',
        'bst2',
        'bst3',
        'bst4',
        'bst5',
        'avg_bst',
        'ect1',
        'ect2',
        'ect3',
        'ect4',
        'ect5',
        'avg_ect',
        'bct1',
        'bct2',
        'bct3',
        'bct4',
        'bct5',
        'avg_bct',
        'created_by',
        'updated_by'
    ];
}
