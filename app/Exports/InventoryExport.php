<?php

namespace App\Exports;

use App\Models\Inventory;
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

class InventoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    protected $filters;
    protected $colorData; // Store color data for each row

    public function __construct($filters = [])
    {
        $this->filters = $filters;
        $this->colorData = [];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Inventory::with(['supplier', 'potongan', 'status_roll']);

        // Apply filters if provided
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('kode_internal', 'like', '%'.$search.'%')
                  ->orWhere('kode_roll', 'like', '%'.$search.'%')
                  ->orWhere('jenis', 'like', '%'.$search.'%')
                  ->orWhere('purchase_order', 'like', '%'.$search.'%')
                  ->orWhere('warna', 'like', '%'.$search.'%')
                  ->orWhere('descoription', 'like', '%'.$search.'%')
                  ->orWhereHas('supplier', function ($query) use ($search) {
                      $query->where('name', 'like', '%'.$search.'%');
                  });
            });
        }

        if (!empty($this->filters['supplier_id'])) {
            $query->where('supplier_id', $this->filters['supplier_id']);
        }

        if (!empty($this->filters['jenis'])) {
            $query->where('jenis', 'like', '%'.$this->filters['jenis'].'%');
        }

        if (!empty($this->filters['tanggal_from'])) {
            $query->whereDate('tanggal_masuk', '>=', $this->filters['tanggal_from']);
        }

        if (!empty($this->filters['tanggal_to'])) {
            $query->whereDate('tanggal_masuk', '<=', $this->filters['tanggal_to']);
        }

        $collection = $query->orderBy('kode_internal', 'asc')->get();
        
        // Store color data for each row (starting from row 2 because row 1 is header)
        $rowIndex = 2;
        foreach ($collection as $inventory) {
            $this->colorData[$rowIndex] = [
                'warna' => $inventory->warna,
                'warna_column' => 'N' // Column N is for Warna
            ];
            $rowIndex++;
        }
        
        return $collection;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Internal',
            'Kode Roll',
            'Supplier',
            'Jenis',
            'GSM',
            'GSM Actual',
            'Lebar (cm)',
            'KW',
            'Tanggal Masuk',
            'Berat SJ (kg)',
            'Berat Timbang (kg)',
            'Quantity',
            'Purchase Order',
            'Warna',
            'Deskripsi',
            'Potongan',
            'Rasio Potongan (%)',
            'Cobsize Top',
            'Cobsize Bottom',
            'RCT CD',
            'RCT MD'
        ];
    }

    /**
     * @param Inventory $inventory
     * @return array
     */
    public function map($inventory): array
    {
        return [
            $inventory->kode_internal ?? '-',
            $inventory->kode_roll ?? '-',
            $inventory->supplier->name ?? '-',
            $inventory->jenis ?? '-',
            $inventory->gsm ?? '-',
            $inventory->gsm_actual ?? '-',
            $inventory->lebar ?? '-',
            $inventory->kw ?? '-',
            $inventory->tanggal_masuk ? \Carbon\Carbon::parse($inventory->tanggal_masuk)->format('Y-m-d') : '-',
            $inventory->berat_sj ? number_format($inventory->berat_sj, 2) : '-',
            $inventory->berat_timbang ? number_format($inventory->berat_timbang, 2) : '-',
            $inventory->quantity == 0 ? '0' : $inventory->quantity,
            $inventory->purchase_order ?? '-',
            $inventory->warna ? 'SAMA' : '-',
            $inventory->descoription ?? '-',
            $inventory->potongan->lebar_potongan ?? '-',
            $inventory->potongan ? number_format($inventory->potongan->rasio, 2) : '-',
            $inventory->cobsize_top ?? '-',
            $inventory->cobsize_bottom ?? '-',
            $inventory->rct_cd ?? '-',
            $inventory->rct_md ?? '-',
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // Kode Internal
            'B' => 20, // Kode Roll
            'C' => 25, // Supplier
            'D' => 20, // Jenis
            'E' => 10, // GSM
            'F' => 12, // GSM Actual
            'G' => 12, // Lebar
            'H' => 8,  // KW
            'I' => 15, // Tanggal Masuk
            'J' => 15, // Berat SJ
            'K' => 15, // Berat Timbang
            'L' => 12, // Quantity
            'M' => 20, // Purchase Order
            'N' => 15, // Warna
            'O' => 30, // Deskripsi
            'P' => 15, // Cobsize Top
            'Q' => 15, // Cobsize Bottom
            'R' => 12, // RCT CD
            'S' => 12, // RCT MD
            'T' => 20, // Potongan
            'U' => 18, // Rasio Potongan
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
                'startColor' => ['rgb' => '28A745'] // Green color for inventory
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

            // Number columns alignment (GSM, Lebar, Berat, Quantity, etc.)
            $numberColumns = ['E', 'F', 'G', 'J', 'K', 'L', 'P', 'Q', 'R', 'S', 'U']; 
            foreach ($numberColumns as $col) {
                $sheet->getStyle($col.'2:'.$col.$highestRow)->getAlignment()
                      ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }

            // Center alignment for some columns
            $centerColumns = ['E', 'F', 'G', 'H', 'I']; // GSM, GSM Actual, Lebar, KW, Tanggal
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
        $title = 'Inventory Export';
        
        if (!empty($this->filters['supplier_id']) || !empty($this->filters['jenis'])) {
            $title .= ' (Filtered)';
        }
        
        return $title;
    }

    /**
     * Map color names to hex values
     */
    private function getColorHex($colorName)
    {
        $colorName = trim($colorName);
        
        // If it's already a hex color (starts with #), clean it and return
        if (strpos($colorName, '#') === 0) {
            return ltrim($colorName, '#');
        }
        
        // If it's a 6-character hex without #
        if (preg_match('/^[A-Fa-f0-9]{6}$/', $colorName)) {
            return $colorName;
        }
        
        $colorMap = [
            // Basic colors
            'merah' => 'FF6B6B',
            'red' => 'FF6B6B',
            'biru' => '4ECDC4',
            'blue' => '4ECDC4',
            'hijau' => '51CF66',
            'green' => '51CF66',
            'kuning' => 'FFE066',
            'yellow' => 'FFE066',
            'orange' => 'FF8C42',
            'oranye' => 'FF8C42',
            'ungu' => 'BE4BDB',
            'purple' => 'BE4BDB',
            'pink' => 'F783AC',
            'merah muda' => 'F783AC',
            'coklat' => 'A0522D',
            'brown' => 'A0522D',
            'hitam' => '495057',
            'black' => '495057',
            'abu-abu' => 'CED4DA',
            'gray' => 'CED4DA',
            'grey' => 'CED4DA',
            'putih' => 'F8F9FA',
            'white' => 'F8F9FA',
            
            // Specific paper colors
            'natural' => 'F5F5DC',
            'cream' => 'F5F5DC',
            'ivory' => 'FFFFF0',
            'beige' => 'F5F5DC',
            'kraft' => 'D2B48C',
            'manila' => 'FFDF9E',
            
            // Default for unknown colors
            'default' => 'FFFFFF'
        ];

        $colorNameLower = strtolower($colorName);
        
        // Check direct match first
        if (isset($colorMap[$colorNameLower])) {
            return $colorMap[$colorNameLower];
        }
        
        // Check if color name contains any of the mapped colors
        foreach ($colorMap as $key => $hex) {
            if (strpos($colorNameLower, $key) !== false) {
                return $hex;
            }
        }
        
        return $colorMap['default'];
    }

    /**
     * Register events for applying colors
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Apply color background to warna column based on the actual color value
                foreach ($this->colorData as $rowIndex => $data) {
                    if (!empty($data['warna']) && $data['warna'] !== '-') {
                        $colorHex = $this->getColorHex($data['warna']);
                        $column = $data['warna_column'];
                        
                        // Apply background color to the warna cell
                        $sheet->getStyle($column . $rowIndex)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => $colorHex]
                            ],
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => $this->getTextColor($colorHex)]
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['rgb' => '000000']
                                ]
                            ]
                        ]);
                    }
                }
            }
        ];
    }

    /**
     * Determine text color (black or white) based on background color brightness
     */
    private function getTextColor($hexColor)
    {
        // Convert hex to RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        
        // Calculate brightness (0-255)
        $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
        
        // Return black text for light backgrounds, white text for dark backgrounds
        return $brightness > 155 ? '000000' : 'FFFFFF';
    }
}