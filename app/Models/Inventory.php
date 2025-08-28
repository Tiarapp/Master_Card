<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Userstamps;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $fillable = [
        'kode_internal',
        'kode_roll', 
        'gsm',
        'jenis',
        'lebar',
        'supplier_id',
        'kw',
        'tanggal_masuk',
        'berat_sj',
        'berat_timbang',
        'quantity',
        'purchase_order',
        'warna',
        'descoription',
        'gsm_actual',
        'cobsize_top',
        'cobsize_bottom',
        'rct_cd',
        'rct_md',
        'created_by',
        'updated_by'
    ];

    public function supplier()
    {
        return $this->belongsTo(SupplierRoll::class);
    }

    public function potongan()
    {
        return $this->belongsTo(Potongan::class);
    }

    public function status_roll()
    {
        return $this->belongsTo(StatusRoll::class);
    }
}
