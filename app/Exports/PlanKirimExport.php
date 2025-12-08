<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PlanKirimExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            // Determine delivery date
            $deliveryDate = '';
            if ($item->dt_perubahan !== '' && $item->approve_mkt == 1 && $item->approve_ppic == 1) {
                $deliveryDate = Carbon::parse($item->dt_perubahan)->format('d/m/Y') . ' (Perubahan)';
            } else {
                $deliveryDate = Carbon::parse($item->tglKirimDt)->format('d/m/Y');
            }

            // Stock status
            $stockStatus = 'N/A';
            if (isset($item->stock_status)) {
                switch ($item->stock_status) {
                    case 'aman':
                        $stockStatus = 'AMAN';
                        break;
                    case 'kurang':
                        $stockStatus = 'KURANG';
                        break;
                    case 'habis':
                        $stockStatus = 'HABIS';
                        break;
                }
            }

            return [
                'no' => $index + 1,
                'no_opi' => $item->NoOPI ?? '-',
                'tanggal_kirim' => $deliveryDate,
                'kode_barang' => $item->mc->kodeBarang ?? '-',
                'nama_barang' => $item->mc->namaBarang ?? '-',
                'customer' => $item->kontrakm->customer_name ?? '-',
                'po_customer' => $item->kontrakm->poCustomer ?? '-',
                'qty_order' => number_format($item->jumlahOrder ?? 0, 0),
                'weight_per_pcs' => number_format($item->mc->gramSheetBoxKontrak2 ?? 0, 2),
                'total_kg' => number_format(($item->jumlahOrder ?? 0) * ($item->mc->gramSheetBoxKontrak2 ?? 0), 2),
                'total_ton' => number_format((($item->jumlahOrder ?? 0) * ($item->mc->gramSheetBoxKontrak2 ?? 0)) / 1000, 3),
                'stock_quantity' => number_format($item->stock_quantity ?? 0, 0),
                'stock_status' => $stockStatus,
                'stock_difference' => number_format($item->stock_difference ?? 0, 0),
                'no_kontrak' => $item->kontrakm->kode ?? '-',
                'tgl_kontrak' => $item->kontrakm->tglKontrak ? Carbon::parse($item->kontrakm->tglKontrak)->format('d/m/Y') : '-',
                'flute' => $item->mc->flute ?? '-',
                'tipe_box' => $item->mc->tipeBox ?? '-',
                'ukuran_sheet' => ($item->mc->panjangSheet ?? 0) . ' x ' . ($item->mc->lebarSheet ?? 0),
                'joint' => $item->mc->joint ?? '-',
                'alamat_kirim' => $item->kontrakm->alamatKirim ?? '-',
                'keterangan' => strlen($item->kontrakm->keterangan ?? '-') > 50 ? substr($item->kontrakm->keterangan ?? '-', 0, 50) . '...' : ($item->kontrakm->keterangan ?? '-'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'No OPI',
            'Tanggal Kirim',
            'Kode Barang',
            'Nama Barang',
            'Customer',
            'PO Customer',
            'Qty Order (pcs)',
            'Weight/pcs (kg)',
            'Total Weight (kg)',
            'Total Tonnage (ton)',
            'Stock Tersedia (pcs)',
            'Status Stock',
            'Selisih Stock',
            'No Kontrak',
            'Tanggal Kontrak',
            'Flute',
            'Tipe Box',
            'Ukuran Sheet (cm)',
            'Joint',
            'Alamat Kirim',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            // Auto-size columns
            'A:S' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 18,  // No OPI
            'C' => 15,  // Tanggal Kirim
            'D' => 25,  // Kode Barang
            'E' => 35,  // Nama Barang
            'F' => 25,  // Customer
            'G' => 20,  // PO Customer
            'H' => 15,  // Qty Order
            'I' => 12,  // Weight/pcs (kg)
            'J' => 15,  // Total Weight (kg)
            'K' => 15,  // Total Tonnage (ton)
            'L' => 15,  // Stock Tersedia
            'M' => 12,  // Status Stock
            'N' => 12,  // Selisih Stock
            'O' => 18,  // No Kontrak
            'P' => 15,  // Tanggal Kontrak
            'Q' => 8,   // Flute
            'R' => 12,  // Tipe Box
            'S' => 18,  // Ukuran Sheet
            'T' => 12,  // Joint
            'U' => 30,  // Alamat Kirim
            'V' => 25,  // Keterangan
        ];
    }

    public function title(): string
    {
        return 'Plan Kirim ' . $this->startDate . ' - ' . $this->endDate;
    }
}