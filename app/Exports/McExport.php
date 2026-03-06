<?php

namespace App\Exports;

use App\Models\Mastercard;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class McExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, WithChunkReading
{
    protected $search;
    protected $customer;
    protected $tipeMc;

    public function __construct($search = null, $customer = null, $tipeMc = null)
    {
        // Increase memory limit for large exports
        ini_set('memory_limit', '1024M');
        
        $this->search = $search;
        $this->customer = $customer;
        $this->tipeMc = $tipeMc;
    }

    public function query()
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

        return $query->orderBy('created_at', 'desc');
    }

    public function chunkSize(): int
    {
        return 1000; // Process 1000 records at a time
    }

    public function map($mastercard): array
    {
        if ($mastercard->revisi == '' || $mastercard->revisi == 'R0') {
            $mc = $mastercard->kode;
        } else {
            $mc = $mastercard->kode . '-' . $mastercard->revisi;
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
            $mastercard->gramSheetBoxProduksi ?? 0,
            $mastercard->gramSheetCorrProduksi ?? 0,
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
            $mastercard->substancekontrak->lineratas ? $mastercard->substancekontrak->lineratas->gramKertas : '',
            $mastercard->substancekontrak->lineratas ? $mastercard->substancekontrak->lineratas->jenisKertasMc : '',
            $mastercard->substancekontrak->flute1 ? $mastercard->substancekontrak->flute1->gramKertas : '',
            $mastercard->substancekontrak->flute1 ? $mastercard->substancekontrak->flute1->jenisKertasMc : '',
            $mastercard->substancekontrak->linertengah ? $mastercard->substancekontrak->linertengah->gramKertas : '',
            $mastercard->substancekontrak->linertengah ? $mastercard->substancekontrak->linertengah->jenisKertasMc : '',
            $mastercard->substancekontrak->flute2 ? $mastercard->substancekontrak->flute2->gramKertas : '',
            $mastercard->substancekontrak->flute2 ? $mastercard->substancekontrak->flute2->jenisKertasMc : '',
            $mastercard->substancekontrak->linerbawah ? $mastercard->substancekontrak->linerbawah->gramKertas : '',
            $mastercard->substancekontrak->linerbawah ? $mastercard->substancekontrak->linerbawah->jenisKertasMc : '',
            $mastercard->substanceproduksi->lineratas ? $mastercard->substanceproduksi->lineratas->gramKertas : '',
            $mastercard->substanceproduksi->lineratas ? $mastercard->substanceproduksi->lineratas->jenisKertasMc : '',
            $mastercard->substanceproduksi->flute1 ? $mastercard->substanceproduksi->flute1->gramKertas : '',
            $mastercard->substanceproduksi->flute1 ? $mastercard->substanceproduksi->flute1->jenisKertasMc : '',
            $mastercard->substanceproduksi->linertengah ? $mastercard->substanceproduksi->linertengah->gramKertas : '',
            $mastercard->substanceproduksi->linertengah ? $mastercard->substanceproduksi->linertengah->jenisKertasMc : '',
            $mastercard->substanceproduksi->flute2 ? $mastercard->substanceproduksi->flute2->gramKertas : '',
            $mastercard->substanceproduksi->flute2 ? $mastercard->substanceproduksi->flute2->jenisKertasMc : '',
            $mastercard->substanceproduksi->linerbawah ? $mastercard->substanceproduksi->linerbawah->gramKertas : '',
            $mastercard->substanceproduksi->linerbawah ? $mastercard->substanceproduksi->linerbawah->jenisKertasMc : '',
            $mastercard->keterangan ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Kode MC',
            'Kode Barang',
            'Tipe Cust',
            'Customer',
            'Nama Barang',
            'Tipe Mc',
            'Tipe Box',
            'Substance Kontrak',
            'Substance Produksi',
            'Ecer',
            'Text',
            'Panjang Dalam Box',
            'Lebar Dalam Box',
            'Tinggi Dalam Box',
            'Berat Kualitas',
            'Flute',
            'Tipe Box',
            'Luas Sheet Box',
            'Luas Sheet',
            'Luas Sheet Box Produksi',
            'Luas Sheet Produksi',
            'Gram Sheet Box Kontrak',
            'Gram Sheet Corrugator Kontrak',
            'Gram Sheet Box Produksi',
            'Gram Sheet Corrugator Produksi',
            'Color Combine 1',
            'Color Combine 2',
            'Color Combine 3',
            'Color Combine 4',
            'Color Combine 5',
            'Color Combine 1 Produksi',
            'Color Combine 2 Produksi',
            'Color Combine 3 Produksi',
            'Color Combine 4 Produksi',
            'Color Combine 5 Produksi',
            'Tipe Creas Corr',
            'Koli',
            'Panjang Sheet Box',
            'Lebar Sheet Box',
            'Panjang Sheet',
            'Lebar Sheet',
            'Gram Sheet Box Produksi 2',
            'Gram Sheet Box Kontrak 2',
            'Liner Atas Kontrak Gram',
            'Liner Atas Kontrak Jenis',
            'Flute 1 Kontrak Gram',
            'Flute 1 Kontrak Jenis',
            'Liner Tengah Kontrak Gram',
            'Liner Tengah Kontrak Jenis',
            'Flute 2 Kontrak Gram',
            'Flute 2 Kontrak Jenis',
            'Liner Bawah Kontrak Gram',
            'Liner Bawah Kontrak Jenis',
            'Liner Atas Produksi Gram',
            'Liner Atas Produksi Jenis',
            'Flute 1 Produksi Gram',
            'Flute 1 Produksi Jenis',
            'Liner Tengah Produksi Gram',
            'Liner Tengah Produksi Jenis',
            'Flute 2 Produksi Gram',
            'Flute 2 Produksi Jenis',
            'Liner Bawah Produksi Gram',
            'Liner Bawah Produksi Jenis',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:BL1')->applyFromArray([
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