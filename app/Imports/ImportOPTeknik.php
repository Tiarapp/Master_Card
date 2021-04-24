<?php

namespace App\Imports;

use App\Models\OPTeknik;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportOPTeknik implements ToCollection
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
            $teknik = OPTeknik::create([
                'kode' => $row[0],
                'nama' => $row[1],
                'periode' => $periode,
                'satuan' => $row[3],
                'saldo_akhir' => $row[2],
                'createdBy' => $row[4]
            ]);

            // dd($teknik, $periode);
        }
    }
}
