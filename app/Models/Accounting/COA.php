<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COA extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $table = 'COA';

    public function get_nomor_coa($coa)
    {
        $coaRecord = self::where('Kode_Bukti', $coa)->first();
        return $coaRecord ? $coaRecord->kd_coa : null;
    }
}
