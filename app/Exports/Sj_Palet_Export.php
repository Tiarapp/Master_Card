<?php

namespace App\Exports;

use App\Models\SJ_Palet_D;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Sj_Palet_Export implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
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
            'Tanggal',
            'No Bukti',
            'Customer',
            'No Polisi',
            'Palet',
            'Ukuran',
            'Quantity',
            'Alamat Customer'
        ];
    }

    public function map($data): array
    {
        return [
            $data['tanggal'],
            $data['noSuratJalan'],
            $data['namaCustomer'],
            $data['noPolisi'],
            $data['palet'],
            $data['ukuran'],
            $data['quantity'],
            $data['alamatCustomer']
        ];
    }
}
