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
        'kodeKontrak',
        'tglKirimDt',
        'pcsDt',
        'kgDt',
        'lock',
        'createdBy',
        'lastUpdatedBy',
    ];
    

}
