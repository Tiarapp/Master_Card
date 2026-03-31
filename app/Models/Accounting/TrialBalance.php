<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialBalance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'Trialbalance';
}
