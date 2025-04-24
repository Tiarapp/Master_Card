<?php

namespace App\Imports;

use App\Models\Accounting\Piutang;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JurnalImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        return new Piutang([
            'NoBukti' => $row['no_bukti'],
            'Note' => $row['jenis'],
            'JTrans' => 'KARTON',
            'Jenis' => 'LOKAL',
            'JenisDK' => $row['debet_kredit'],
            'Periode' => $row['periode'],
            'Tanggal' => isset($row['tanggal']) 
                        ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']))
                        : null,
            'TglJT' => isset($row['jatuh_tempo']) 
                        ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['jatuh_tempo']))
                        : null,
            'KodeCust' => $row['kode_customer'],
            'NamaCust' => $row['nama_customer'],
            'KodeGroupCust' => $row['kode_customer'],
            'GroupCust' => $row['nama_customer'],
            'KdPerkiraan' => '1102.01.01.01',
            'MataUang' => $row['matauang'],
            'NilaiKurs' => 1,
            'Total' => $row['total'],
            'TotalRp' => $row['total'],
            'TotalTerima' => 0,
            'Penjualan' => $row['penjualan'],
            'PPN' => $row['ppn'],
            'PPH' => $row['pph'],
            'SJINV' => 'I',
            'KdDept' => 31,
            'External' => 'up'
        ]);
    }
}
