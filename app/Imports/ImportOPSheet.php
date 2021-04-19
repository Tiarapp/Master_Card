<?php

namespace App\Imports;

use App\Models\OPSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportOPSheet implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $year = date('Y');
        $month = date('m');

        $periode = "$month/$year";  

        foreach ($rows as $row){
            OPSheet::create([
                'kode_barang' => $row[1],
                'nama' => $row[2],
                'periode' => $periode,
                'flute' => $row[3],
                'createdBy' => $row[4],
                'saldo_akhir' => $row[5],
            ]);
        }
    }
}
