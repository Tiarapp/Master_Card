<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTTDet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'VendTTDet';

    protected $fillable = [
        'NoTT',
        'InvNumber',
        'PONumber', 
        'BBMNo',
        'Amount',
        'BBMAmount',
        'RefPPN',
        'TglPPN',
    ];

    public function master_vend()
    {
        return $this->belongsTo(VendorTT::class, 'NoTT', 'NoTT');
    }
}
