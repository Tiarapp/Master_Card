<?php

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OpiExportReport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        return [
            'Nomor OPI',
            'Customer',
            'Nama Barang',
            'Sales',
            'Tipe Box',
            'Flute',
            'Harga per Kg',
            'Nomor Kontrak',
            'Tgl Kontrak',
            'Qty OPI (pcs)',
            'Qty OPI (kg)',
            'Tanggal Estimasi Kirim',
            'Tanggal Kirim',
            'Qty Realisasi (pcs)',
            'Qty Realisasi (kg)',
        ];
    }

    public function map($row): array
    {
        return [
            $row->NoOPI,
            $row->customer_name ?? '',
            $row->namaBarang ?? '',
            $row->sales ?? '',
            $row->tipeBox ?? '',
            $row->flute ?? '',
            $row->harga_kg ?? '',
            $row->kontrak_kode ?? '',
            $row->tgl_kontrak ?? '',
            $row->jumlahOrder,
            $row->gram ? round($row->jumlahOrder * $row->gram, 2) : '',
            $row->tgl_estimasi ?? '',
            $row->tgl_kirim ?? '',
            $row->total_qty,
            round($row->total_kg, 2),
        ];
    }
}
