<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanKirim extends Model
{
    protected $table = 'plan_kirim';

    protected $fillable = ['nama', 'tgl_plan', 'catatan', 'created_by', 'updated_by'];

    protected $casts = [
        'tgl_plan' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(PlanKirimItem::class, 'plan_kirim_id')->orderBy('urutan');
    }
}
