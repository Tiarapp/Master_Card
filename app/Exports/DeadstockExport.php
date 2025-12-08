<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DeadstockExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $stock;

    public function __construct($stock)
    {
        $this->stock = $stock;
    }

    public function collection()
    {
        return $this->stock;
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Saldo Akhir (Crt)',
            'Saldo Akhir (Kg)', 
            'Periode',
            'Tanggal SJ Terakhir',
            'Hari Sejak SJ Terakhir',
            'Kategori Deadstock'
        ];
    }

    public function map($item): array
    {
        return [
            $item->KodeBrg,
            $item->NamaBrg ?? '',
            $item->SaldoAkhirCrt,
            $item->SaldoAkhirKg,
            $item->Periode,
            $item->LastSJDate ? \Carbon\Carbon::parse($item->LastSJDate)->format('d/m/Y') : 'Tidak ada',
            $item->DaysSinceLastSJ ?? 'N/A',
            $item->DeadstockCategory
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50']
                ]
            ],
            // Add borders to all cells
            'A1:G' . ($this->stock->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Kode Barang
            'B' => 15, // Saldo Akhir (Crt)
            'C' => 15, // Saldo Akhir (Kg)
            'D' => 12, // Periode
            'E' => 18, // Tanggal SJ Terakhir
            'F' => 20, // Hari Sejak SJ Terakhir
            'G' => 25, // Kategori Deadstock
        ];
    }
}