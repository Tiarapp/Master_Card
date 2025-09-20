<?php

namespace App\Models\Accounting;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // Custom accessor untuk purchase order data (cross-database)
    public function getPurchaseOrderAttribute()
    {
        if (!$this->PONumber) {
            return null;
        }

        try {
            return DB::connection('mysql')
                ->table('purchase_orders')
                ->where('po_number', $this->PONumber)
                ->first();
        } catch (\Exception $e) {
            // Return null jika tabel tidak ada atau error
            return null;
        }
    }

    // Custom accessor untuk TOP (Terms of Payment)
    public function getTopAttribute()
    {
        $po = $this->purchase_order;
        return $po ? $po->top : null;
    }
}
