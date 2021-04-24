<?php

namespace App\Imports;

use App\Models\OPRoll;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportOPRoll implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        
        $year = date('Y');
        $month = date('m');

        $periode = "$month/$year";

        foreach ($rows as $row) {
            OPRoll::create([
                'kode' => $row[0],
                'nama' => $row[1],
                'periode' => $periode,
                'saldo_akhir' => $row[2],
                'createdBy' => $row[3],
            ]);
        }
    }
}
