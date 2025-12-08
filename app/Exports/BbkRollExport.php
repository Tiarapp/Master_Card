<?php

namespace App\Exports;

use App\Models\BbkRoll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BbkRollExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = BbkRoll::with(['inventory.supplier']);

        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('bbk_number', 'like', '%'.$search.'%')
                  ->orWhere('opi', 'like', '%'.$search.'%')
                  ->orWhere('keterangan', 'like', '%'.$search.'%')
                  ->orWhereHas('inventory', function ($query) use ($search) {
                      $query->where('kode_internal', 'like', '%'.$search.'%')
                            ->orWhere('kode_roll', 'like', '%'.$search.'%');
                  });
            });
        }

        if (!empty($this->filters['inventory_filter'])) {
            $query->where('inventory_id', $this->filters['inventory_filter']);
        }

        if (!empty($this->filters['tanggal_from'])) {
            $query->whereDate('tanggal_bbk', '>=', $this->filters['tanggal_from']);
        }

        if (!empty($this->filters['tanggal_to'])) {
            $query->whereDate('tanggal_bbk', '<=', $this->filters['tanggal_to']);
        }

        return $query->orderBy('bbk_number', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'BBK Number',
            'Tanggal BBK',
            'Kode Internal',
            'Kode Roll',
            'Supplier',
            'Jenis',
            'GSM',
            'Lebar (cm)',
            'Keluar (kg)',
            'Kembali (kg)',
            'Pakai (kg)',
            'Kembali + Rasio (kg)',
            'OPI',
            'Keterangan',
            'Dibuat Oleh',
            'Diupdate Oleh',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    /**
     * @param BbkRoll $bbkRoll
     * @return array
     */
    public function map($bbkRoll): array
    {
        $pakai = $bbkRoll->keluar - $bbkRoll->kembali;
        
        // Calculate Kembali + Rasio if inventory has potongan
        $kembaliRasio = $bbkRoll->kembali;
        if ($bbkRoll->inventory->potongan_id && $bbkRoll->inventory->potongan) {
            $rasio = $bbkRoll->inventory->potongan->rasio;
            $kembaliRasio = $bbkRoll->kembali + ($bbkRoll->kembali * $rasio / 100);
        }

        return [
            $bbkRoll->bbk_number,
            $bbkRoll->tanggal_bbk,
            $bbkRoll->inventory->kode_internal ?? '-',
            $bbkRoll->inventory->kode_roll ?? '-',
            $bbkRoll->inventory->supplier->name ?? '-',
            $bbkRoll->inventory->jenis ?? '-',
            $bbkRoll->inventory->gsm ?? '-',
            $bbkRoll->inventory->lebar ?? '-',
            number_format($bbkRoll->keluar, 2),
            number_format($bbkRoll->kembali, 2),
            number_format($pakai, 2),
            $bbkRoll->inventory->potongan_id ? number_format($kembaliRasio, 2) : '-',
            $bbkRoll->opi ?? '-',
            $bbkRoll->keterangan ?? '-',
            $bbkRoll->createdBy->name ?? '-',
            $bbkRoll->updatedBy->name ?? '-',
            $bbkRoll->created_at->format('Y-m-d H:i:s'),
            $bbkRoll->updated_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // BBK Number
            'B' => 12, // Tanggal BBK
            'C' => 15, // Kode Internal
            'D' => 15, // Kode Roll
            'E' => 20, // Supplier
            'F' => 15, // Jenis
            'G' => 8,  // GSM
            'H' => 12, // Lebar
            'I' => 12, // Keluar
            'J' => 12, // Kembali
            'K' => 12, // Pakai
            'L' => 15, // Kembali + Rasio
            'M' => 15, // OPI
            'N' => 25, // Keterangan
            'O' => 15, // Dibuat Oleh
            'P' => 15, // Diupdate Oleh
            'Q' => 18, // Tanggal Dibuat
            'R' => 18, // Tanggal Diupdate
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Header styling
        $sheet->getStyle('A1:'.$highestColumn.'1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4E73DF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Data rows styling
        if ($highestRow > 1) {
            $sheet->getStyle('A2:'.$highestColumn.$highestRow)->applyFromArray([
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ]
            ]);

            // Number columns alignment
            $numberColumns = ['I', 'J', 'K', 'L']; // Keluar, Kembali, Pakai, Kembali+Rasio
            foreach ($numberColumns as $col) {
                $sheet->getStyle($col.'2:'.$col.$highestRow)->getAlignment()
                      ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }

            // Center alignment for some columns
            $centerColumns = ['B', 'G', 'H']; // Tanggal, GSM, Lebar
            foreach ($centerColumns as $col) {
                $sheet->getStyle($col.'2:'.$col.$highestRow)->getAlignment()
                      ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'BBK Roll Export';
        
        if (!empty($this->filters['tanggal_from']) || !empty($this->filters['tanggal_to'])) {
            $from = $this->filters['tanggal_from'] ?? 'All';
            $to = $this->filters['tanggal_to'] ?? 'All';
            $title .= " ({$from} to {$to})";
        }
        
        return $title;
    }
}