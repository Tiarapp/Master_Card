<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanKirimItem extends Model
{
    protected $table = 'plan_kirim_item';

    protected $fillable = ['plan_kirim_id', 'opi_id', 'urutan'];
}
