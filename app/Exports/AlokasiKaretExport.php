<?php

namespace App\Exports;

use App\Models\Karet;
use App\Models\AlokasiKaret;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AlokasiKaretExport implements FromCollection, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    protected $search;
    protected $salesName;

    public function __construct($search = null, $salesName = null)
    {
        $this->search = $search;
        $this->salesName = $salesName;
    }

    public function collection()
    {
        $alokasi = Karet::with(['mastercard', 'alokasiKarets']);

        if ($this->search) {
            $alokasi = $alokasi->where('customer', 'like', '%' . $this->search . '%')
                ->orWhere('nama_karet', 'like', '%' . $this->search . '%');
        }

        if ($this->salesName) {
            $alokasi = $alokasi->where('sales_name', $this->salesName);
        }

        // Only show items with sisa >= 0
        $alokasi = $alokasi->where('sisa', '>=', 0);

        return $alokasi->orderBy('id', 'asc')->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Get all unique months
                $months = AlokasiKaret::selectRaw('YEAR(tanggal_kirim) as year, MONTH(tanggal_kirim) as month')
                    ->distinct()
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get()
                    ->map(function($item) {
                        $date = Carbon::createFromDate($item->year, $item->month, 1);
                        return $date->format('F Y');
                    });

                // Insert 2 empty rows at the top for headers
                $sheet->insertNewRowBefore(1, 2);
                
                // First row headers (basic info)
                $sheet->setCellValue('A1', 'Nama Karet');
                $sheet->setCellValue('B1', 'Customer');
                $sheet->setCellValue('C1', 'Sales');
                $sheet->setCellValue('D1', 'Harga Karet');
                $sheet->setCellValue('E1', 'GSM');
                $sheet->setCellValue('F1', 'MC');
                $sheet->setCellValue('G1', 'Harga Per KG');
                $sheet->setCellValue('H1', 'Lokasi Kirim');
                $sheet->setCellValue('I1', 'Tanggal Masuk');
                $sheet->setCellValue('J1', 'Alokasi');
                
                // Second row (empty for basic info, will be filled with PCS/Alokasi for months)
                $sheet->setCellValue('A2', '');
                $sheet->setCellValue('B2', '');
                $sheet->setCellValue('C2', '');
                $sheet->setCellValue('D2', '');
                $sheet->setCellValue('E2', '');
                $sheet->setCellValue('F2', '');
                $sheet->setCellValue('G2', '');
                $sheet->setCellValue('H2', '');
                $sheet->setCellValue('I2', '');
                $sheet->setCellValue('J2', '');
                
                // Add month headers starting from column K
                $col = 11; // K column (11th column)
                foreach ($months as $month) {
                    $colLetter1 = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                    $colLetter2 = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                    
                    // Month name in first row, merged across 2 columns
                    $sheet->setCellValue($colLetter1 . '1', $month);
                    $sheet->mergeCells($colLetter1 . '1:' . $colLetter2 . '1');
                    
                    // PCS and Alokasi in second row
                    $sheet->setCellValue($colLetter1 . '2', 'PCS');
                    $sheet->setCellValue($colLetter2 . '2', 'Alokasi');
                    
                    $col += 2;
                }
                
                // Add Sisa column at the end
                $colLetterSisa = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $sheet->setCellValue($colLetterSisa . '1', 'Sisa');
                $sheet->setCellValue($colLetterSisa . '2', '');
                
                $col += 1;
                
                // Style headers
                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col - 1);
                
                // Style first row
                $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4CAF50']
                    ],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
                ]);
                
                // Style second row
                $sheet->getStyle('A2:' . $lastColumn . '2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '66BB6A']
                    ],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
                ]);
            }
        ];
    }

    public function map($karet): array
    {
        // Get all unique months from all transactions
        $months = AlokasiKaret::selectRaw('YEAR(tanggal_kirim) as year, MONTH(tanggal_kirim) as month')
            ->distinct()
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                return [
                    'format' => $date->format('F Y'),
                    'key' => $date->format('Y-m')
                ];
            });

        // Get transactions for this karet grouped by month
        $transaksiPerBulan = AlokasiKaret::where('karet_id', $karet->id)
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->tanggal_kirim)->format('Y-m');
            });

        $row = [
            $karet->nama_karet,
            $karet->customer,
            $karet->sales_name,
            'Rp ' . number_format($karet->harga, 0, ',', '.'),
            number_format($karet->gsm, 3),
            $karet->mastercard ? $karet->mastercard->kode : '-',
            'Rp ' . number_format($karet->harga_per_kg, 0, ',', '.'),
            $karet->lokasi_kirim,
            Carbon::parse($karet->tanggal_masuk)->format('d/m/Y'),
            number_format($karet->alokasi, 0)
        ];

        // Add monthly data
        foreach ($months as $month) {
            $monthKey = $month['key'];
            if (isset($transaksiPerBulan[$monthKey])) {
                $monthData = $transaksiPerBulan[$monthKey];
                $row[] = number_format($monthData->sum('pcs'), 0); // PCS
                $row[] = 'Rp ' . number_format($monthData->sum('alokasi_harga'), 0, ',', '.'); // Alokasi
            } else {
                $row[] = '0'; // PCS
                $row[] = 'Rp 0'; // Alokasi
            }
        }

        // Add Sisa column at the end
        $row[] = number_format($karet->sisa, 0);

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        // Basic styling will be handled in registerEvents
        return [];
    }
}