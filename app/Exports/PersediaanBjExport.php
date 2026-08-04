<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PersediaanBjExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
            'Kode Barang',
            'Nama Barang',
            'Berat Standart',
            'Periode',
            'Saldo Awal Pcs',
            'Saldo Awal Kg',
            'Masuk Pcs',
            'Masuk Kg',
            'Keluar Pcs',
            'Keluar Kg',
            'Adjustment Credit Pcs',
            'Adjustment Credit Kg',
            'Adjustment Debet Pcs',
            'Adjustment Debet Kg',
            'Saldo Akhir Pcs',
            'Saldo Akhir Kg',
        ];
    }

    public function map($row): array
    {
        return [
            $row->KodeBrg ?? '',
            $row->NamaBrg ?? '',
            $row->BeratStandart ?? 0,
            $row->Periode ?? '',
            $row->SaldoAwalCrt ?? 0,
            $row->SaldoAwalKg ?? 0,
            $row->MasukCrt ?? 0,
            $row->MasukKg ?? 0,
            $row->KeluarCrt ?? 0,
            $row->KeluarKg ?? 0,
            $row->AdjCRCrt ?? 0,
            $row->AdjCRKg ?? 0,
            $row->AdjDBCrt ?? 0,
            $row->AdjDBKg ?? 0,
            $row->SaldoAkhirCrt ?? 0,
            $row->SaldoAkhirKg ?? 0,
        ];
    }
}