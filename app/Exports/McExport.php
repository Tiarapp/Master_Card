<?php

namespace App\Exports;

use App\Models\Mastercard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class McExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $search;
    protected $customer;
    protected $tipeMc;

    public function __construct($search = null, $customer = null, $tipeMc = null)
    {
        $this->search = $search;
        $this->customer = $customer;
        $this->tipeMc = $tipeMc;
    }

    public function collection()
    {
        $query = Mastercard::with(['substancekontrak', 'substanceproduksi', 'box', 'colorcombine']);

        // Apply search filters
        if ($this->search) {
            $query->where(function($q) {
                $q->where('kode', 'like', '%' . $this->search . '%')
                  ->orWhere('namaBarang', 'like', '%' . $this->search . '%')
                  ->orWhere('kodeBarang', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->customer) {
            $query->where('customer', 'like', '%' . $this->customer . '%');
        }

        if ($this->tipeMc) {
            $query->where('tipeMc', $this->tipeMc);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function map($mastercard): array
    {
        if ($mastercard->revisi != '' || $mastercard->revisi != 'R0') {
            $mc = $mastercard->kode . '-' . $mastercard->revisi;
        } else {
            $mc = $mastercard->kode;
        }

        return [
            $mc ?? '',
            $mastercard->kodeBarang ?? '',
            $mastercard->tipeCust ?? '',
            $mastercard->customer ?? '',
            $mastercard->namaBarang ?? '',
            "LOKAL",
            "SHEET",
            $mastercard->substanceKontrak->namaMc ?? '',
            $mastercard->substanceProduksi->namaMc ?? '',
            "ECER",
            $mastercard->text ?? 'Non Block',
            $mastercard->box->panjangDalamBox ?? 0,
            $mastercard->box->lebarDalamBox ?? 0,
            $mastercard->box->tinggiDalamBox ?? 0,
            $mastercard->brt_kualitas ?? 0,
            $mastercard->flute ?? '',
            $mastercard->tipeBox ?? '',
            $mastercard->luasSheetBox ?? 0,
            $mastercard->luasSheet ?? 0,
            $mastercard->luasSheetBoxProd ?? 0,
            $mastercard->luasSheetProd ?? 0,
            $mastercard->gramSheetBoxKontrak ?? 0,
            $mastercard->gramSheetCorrKontrak ?? 0,
            $mastercard->gramSheetBoxProd ?? 0,
            $mastercard->gramSheetCorrProd ?? 0,
            $mastercard->colorcombine->color1->nama ?? '',
            $mastercard->colorcombine->color2->nama ?? '',
            $mastercard->colorcombine->color3->nama ?? '',
            $mastercard->colorcombine->color4->nama ?? '',
            $mastercard->colorcombine->color5->nama ?? '',
            $mastercard->colorcombine->color1->nama ?? '',
            $mastercard->colorcombine->color2->nama ?? '',
            $mastercard->colorcombine->color3->nama ?? '',
            $mastercard->colorcombine->color4->nama ?? '',
            $mastercard->colorcombine->color5->nama ?? '',
            $mastercard->box->tipeCreasCorr ?? '',
            $mastercard->koli ?? '',
            $mastercard->panjangSheetBox ?? 0,
            $mastercard->lebarSheetBox ?? 0,
            $mastercard->panjangSheet ?? 0,
            $mastercard->lebarSheet ?? 0,
            $mastercard->gramSheetBoxProduksi2 ?? 0,
            $mastercard->gramSheetBoxKontrak2 ?? 0,

            $mastercard->tipeMc ?? '',
            number_format($mastercard->panjangSheet ?? 0, 2),
            number_format($mastercard->lebarSheet ?? 0, 2),
            number_format($mastercard->luasSheet ?? 0, 2),
            number_format($mastercard->panjangSheetBox ?? 0, 2),
            number_format($mastercard->lebarSheetBox ?? 0, 2),
            number_format($mastercard->luasSheetBox ?? 0, 2),
            $mastercard->colorCombine->nama ?? '',
            $mastercard->joint ?? '',
            $mastercard->koli ?? '',
            number_format($mastercard->outConv ?? 0, 2),
            number_format($mastercard->brt_kualitas ?? 0, 2),
            $mastercard->mesin ?? '',
            $mastercard->wax ?? '',
            $mastercard->doubleJoint ?? '',
            $mastercard->createdBy ?? '',
            $mastercard->created_at ? $mastercard->created_at->format('Y-m-d') : '',
            $mastercard->keterangan ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Kode MC',
            'Nama Barang',
            'Kode Barang',
            'Customer',
            'Tipe MC',
            'Tipe Box',
            'Flute',
            'Panjang Sheet (mm)',
            'Lebar Sheet (mm)',
            'Luas Sheet (m²)',
            'Panjang Sheet Box (mm)',
            'Lebar Sheet Box (mm)',
            'Luas Sheet Box (m²)',
            'Substance Kontrak',
            'Substance Produksi',
            'Warna',
            'Joint',
            'Koli',
            'Out Conv',
            'Berat Kualitas',
            'Mesin',
            'Wax',
            'Double Joint',
            'Created By',
            'Tanggal Dibuat',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:AA1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '366092'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set row height for header
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Add borders to all data
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => Color::COLOR_BLACK],
                        ],
                    ],
                ]);

                // Center align specific columns
                $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Kode MC
                $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Revisi
                $sheet->getStyle('F:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tipe MC, Box, Flute
                $sheet->getStyle('R:U')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Joint, Koli, etc
                
                // Right align numeric columns
                $sheet->getStyle('I:N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Measurements
                $sheet->getStyle('T:U')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Out Conv, Berat
                
                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(15); // Kode MC
                $sheet->getColumnDimension('C')->setWidth(25); // Nama Barang
                $sheet->getColumnDimension('D')->setWidth(20); // Kode Barang
                $sheet->getColumnDimension('E')->setWidth(20); // Customer
                $sheet->getColumnDimension('O')->setWidth(20); // Substance Kontrak
                $sheet->getColumnDimension('P')->setWidth(20); // Substance Produksi
                $sheet->getColumnDimension('AA')->setWidth(30); // Keterangan
            },
        ];
    }
}