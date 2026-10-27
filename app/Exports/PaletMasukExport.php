<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaletMasukExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
            'Tanggal Masuk',
            'Customer',
            'Kota',
            'Jenis Palet',
            'Palet',
            'Ukuran',
            'Qty Bagus',
            'Qty Jelek',
            'Total',
            'Keterangan',
            'Dicatat Oleh',
        ];
    }

    public function map($row): array
    {
        return [
            \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y'),
            $row->namaCustomer,
            $row->noPolisi,
            $row->jenisPalet,
            $row->palet,
            $row->ukuran,
            $row->qty_bagus,
            $row->qty_jelek,
            $row->qty,
            $row->keterangan,
            $row->createdBy,
        ];
    }
}
