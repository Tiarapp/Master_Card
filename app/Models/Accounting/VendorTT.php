<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTT extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'VendorTT';

    protected $fillable = [
        'NoTT',
        'SupplierName',
        'Tglterima',
        'SupplierCode'
    ];
}
