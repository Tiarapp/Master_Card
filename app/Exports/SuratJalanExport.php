<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SuratJalanExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No. Surat Jalan',
            'MOD',
            'Kontrak',
            'PO',
            'Customer',
            'Kode Barang',
            'Nama Barang', 
            'Berat Std',
            'PCS',
            'KG',
            'Kirim Ke',
            'Expedisi',
            'No. Kendaraan',
            'Jenis Order',
            'Jenis Kendaraan',
            'OPI',
        ];
    }

    public function map($data): array
    {
        return [
            !empty($data->TglSJ) ? ExcelDate::dateTimeToExcel(Carbon::parse($data->TglSJ)) : null,
            trim((string) ($data->NomerSJ ?? '')),
            trim($data->NomerMOD) ?? '',
            trim($data->NomerSC) ?? '',
            trim($data->NomerPI_PO) ?? '',
            trim($data->NamaCust) ?? '',
            trim($data->KodeBrg) ?? '',
            trim($data->NamaBrg) ?? '',
            $data->BeratStandart ?? '',
            $data->Quantity ?? '',
            $data->Quantity * $data->BeratStandart ?? '',
            trim($data->KirimKe) ?? '',
            trim($data->NamaSupplier) ?? trim($data->Expedisi) ?? '',
            trim($data->NoKend) ?? '',
            trim($data->JenisOrder) ?? '',
            trim($data->CaraAngkut) ?? '',
            trim($data->NoSeal) ?? '',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
