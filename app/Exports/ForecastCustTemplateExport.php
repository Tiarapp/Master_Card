<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ForecastCustTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        // Sample data for template in pivot format
        return [
            [
                'PT ABC Indonesia',
                'John Doe',
                2026,
                150.50, // Jan
                145.75, // Feb
                160.25, // Mar
                140.00, // Apr
                155.30, // May
                165.45, // Jun
                170.20, // Jul
                175.80, // Aug
                180.15, // Sep
                185.60, // Oct
                190.25, // Nov
                195.75  // Dec
            ],
            [
                'CV Platinum Jaya',
                'Jane Smith', 
                2026,
                200.75, // Jan
                205.50, // Feb
                210.25, // Mar
                195.80, // Apr
                215.30, // May
                220.45, // Jun
                225.60, // Jul
                230.75, // Aug
                235.90, // Sep
                240.15, // Oct
                245.30, // Nov
                250.50  // Dec
            ],
            [
                'PT XYZ Corporation',
                'Bob Wilson',
                2026,
                120.25, // Jan
                125.50, // Feb
                130.75, // Mar
                115.30, // Apr
                135.45, // May
                140.60, // Jun
                145.75, // Jul
                150.90, // Aug
                155.15, // Sep
                160.30, // Oct
                165.45, // Nov
                170.60  // Dec
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'customer_name',
            'sales_name', 
            'tahun',
            'jan_target',
            'feb_target', 
            'mar_target',
            'apr_target',
            'may_target',
            'jun_target',
            'jul_target',
            'aug_target',
            'sep_target',
            'oct_target',
            'nov_target',
            'dec_target'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'size' => 12]],
            
            // Background color for header
            'A1:O1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFC6EFCE',
                    ],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
            
            // Add borders to data rows
            'A2:O4' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,  // customer_name
            'B' => 20,  // sales_name
            'C' => 10,  // tahun
            'D' => 12,  // jan_target
            'E' => 12,  // feb_target
            'F' => 12,  // mar_target
            'G' => 12,  // apr_target
            'H' => 12,  // may_target
            'I' => 12,  // jun_target
            'J' => 12,  // jul_target
            'K' => 12,  // aug_target
            'L' => 12,  // sep_target
            'M' => 12,  // oct_target
            'N' => 12,  // nov_target
            'O' => 12,  // dec_target
        ];
    }
}
