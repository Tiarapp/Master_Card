<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    protected $table = 'dt';

    protected $fillable = [
        'kontrak_m_id',
        'opi',
        'kodeKontrak',
        'tglKirimDt',
        'dt_perubahan',
        'pcsDt',
        'kgDt',
        'locked',
        'createdBy',
        'keterangan',
        'lastUpdatedBy',
    ];

    public static function effectiveDate($original, $change, $approvedPpic)
    {
        return $change !== null && $change !== '' && $approvedPpic == 1
            ? $change
            : $original;
    }

    public function opi()
    {
        return $this->belongsTo(Opi_M::class, 'opi', 'id');
    }

}
