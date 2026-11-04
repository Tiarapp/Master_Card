<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesCustomerExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Sales',
            'Status Sales',
            'Customer',
            'Jumlah Kontrak',
            'Kontrak Pertama',
            'Kontrak Terakhir',
        ];
    }

    public function map($row): array
    {
        $fmt = function ($d) {
            return $d ? \Carbon\Carbon::parse($d)->format('d-m-Y') : '';
        };

        return [
            $row->sales_nama,
            $row->sales_status,
            $row->customer_nama,
            $row->jumlah_kontrak,
            $fmt($row->kontrak_pertama),
            $fmt($row->kontrak_terakhir),
        ];
    }
}
