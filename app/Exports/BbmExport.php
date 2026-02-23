<?php

namespace App\Exports;

use App\Models\Firebird\Stellar\BP\DetBbm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BbmExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents
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
        DB::connection('stellar_bp')->beginTransaction();
        $bbm = new DetBbm();
        $bbm = $bbm->with('barang', 'master_bbm')
                ->whereHas('master_bbm', function($query) {
                    $query->where('NoBukti', 'like', 'PHP%');
                });

        // Apply period filter if provided
        if (!empty($this->filters['period'])) {
            $period = $this->filters['period'];
            list($year, $month) = explode('-', $period);
            
            $startDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $bbm = $bbm->whereHas('master_bbm', function($query) use ($startDate, $endDate) {
                $query->whereBetween('TglMasuk', [$startDate, $endDate]);
            });
        }

        // Apply search filter if provided
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $bbm = $bbm->whereHas('barang', function($query) use ($search) {
                $query->where('NamaBrg', 'like', '%' . $search . '%');
            })->orWhereHas('master_bbm', function($query) use ($search) {
                $query->where('NoBukti', 'like', '%' . $search . '%');
            });
        }

        return $bbm->orderBy('NoUrut', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal BBM',
            'No BBM',
            'Kode Barang',
            'Nama Barang',
            'No OP',
            'Qty P',
            'Qty S', 
            'Harga',
            'Subtotal',
            'Keterangan'
        ];
    }

    /**
     * Map the data for each row
     */
    public function map($row): array
    {
        static $no = 1;
        
        $subtotal = ($row->QtyP ?? 0) * ($row->Harga ?? 0);
        
        return [
            $no++,
            $row->master_bbm->TglMasuk ?? '-',
            $row->master_bbm->NoBukti ?? '-',
            $row->barang->KodeBrg ?? '-',
            $row->barang->NamaBrg ?? '-',
            $row->NoOP ?? '-',
            $row->QtyP ?? 0,
            $row->QtyS ?? 0,
            $row->Harga ?? 0,
            $subtotal,
            $row->Keterangan ?? '-'
        ];
    }

    /**
     * Apply styles to the spreadsheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2EFDA']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            // Center align specific columns
            'A:A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'G:J' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
        ];
    }

    /**
     * Set column widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 12,  // Tanggal BBM
            'C' => 15,  // No BBM  
            'D' => 15,  // Kode Barang
            'E' => 30,  // Nama Barang
            'F' => 12,  // No OP
            'G' => 12,  // Qty P
            'H' => 12,  // Qty S
            'I' => 15,  // Harga
            'J' => 15,  // Subtotal
            'K' => 20,  // Keterangan
        ];
    }

    /**
     * Set sheet title
     */
    public function title(): string
    {
        $title = 'Data BBM';
        
        if (!empty($this->filters['period'])) {
            $period = date('m/Y', strtotime($this->filters['period'] . '-01'));
            $title .= ' - ' . $period;
        }
        
        return $title;
    }

    /**
     * Handle events
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Get the highest row and column
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                
                // Apply borders to all cells
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);
                
                // Auto filter for header row
                $sheet->setAutoFilter('A1:' . $highestColumn . '1');
                
                // Freeze the header row
                $sheet->freezePane('A2');
            }
        ];
    }
}