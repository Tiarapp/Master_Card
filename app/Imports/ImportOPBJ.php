<?php

namespace App\Imports;

use App\Models\OPBJ;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportOPBJ implements ToCollection
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
            OPBJ::create([
                'kode' => $row[1],
                'nama' => $row[2],
                'periode' => $periode,
                'saldo_akhir' => $row[3],
                'createdBy' => $row[4]
            ]);
        }
    }
}
