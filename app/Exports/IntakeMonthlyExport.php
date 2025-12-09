<?php

namespace App\Exports;

use App\Models\Opi_M;
use App\Models\HasilProduksi;
use App\Models\RealisasiKirim;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IntakeMonthlyExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    protected $month;
    protected $year;
    
    public function __construct($month = null, $year = null)
    {
        $this->month = $month ?: date('m');
        $this->year = $year ?: date('Y');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Get intake data for specified month
        $startDate = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth();

        $query = Opi_M::query()
            ->leftJoin('kontrak_m', 'opi_m.kontrak_m_id', '=', 'kontrak_m.id')
            ->leftJoin('kontrak_d', 'opi_m.kontrak_d_id', '=', 'kontrak_d.id')
            ->leftJoin('mc', 'kontrak_d.mc_id', '=', 'mc.id')
            ->leftJoin('dt', 'opi_m.dt_id', '=', 'dt.id')
            ->select([
                'opi_m.id',
                'opi_m.NoOPI',
                'opi_m.jumlahOrder',
                'opi_m.keterangan as opi_keterangan',
                'opi_m.created_at as intake_date',
                'kontrak_m.tglKontrak',
                'kontrak_m.customer_name',
                'kontrak_m.poCustomer',
                'kontrak_m.kode as noKontrak',
                'kontrak_m.tipeOrder',
                'kontrak_d.harga_pcs',
                'kontrak_d.harga_kg',
                'mc.namaBarang',
                'mc.tipeBox',
                'mc.wax',
                'mc.gramSheetBoxKontrak',
                'dt.tglKirimDt'
            ])
            ->where('opi_m.status_opi', '!=', 'Cancel')
            ->whereYear('opi_m.created_at', $this->year)
            ->whereMonth('opi_m.created_at', $this->month)
            ->orderBy('dt.tglKirimDt', 'asc');

        return $query->get();
    }

    /**
    * @var mixed $opi
    */
    public function map($opi): array
    {
        // Get hasil produksi (qty kirim) untuk OPI ini
        $realisasi = RealisasiKirim::where('opi_id', $opi->id)
            ->select([
                DB::raw('SUM(qty_kirim) as total_qty_kirim'),
                DB::raw('SUM(kg_kirim) as total_ton_kirim'),
                DB::raw('MAX(end_date) as tanggal_kirim_terakhir')
            ])
            ->first();

        $qtyKirim = $realisasi->total_qty_kirim ?? 0;
        $tonKirim = $realisasi->total_ton_kirim ?? 0;
        $tanggalKirim = $realisasi->tanggal_kirim_terakhir ?? '-';

        // Calculations
        $beratKg = ($opi->gramSheetBoxKontrak ?? 0) / 1000; // Convert gram to kg
        $tonase = ($opi->jumlahOrder ?? 0) * $beratKg; // Qty * berat in tons
        
        $kurangKirim = ($opi->jumlahOrder ?? 0) - $qtyKirim;
        $tonKurangKirim = $kurangKirim * $beratKg;

        return [
            $opi->tglKontrak ? date('d/m/Y', strtotime($opi->tglKontrak)) : '-', // Tanggal Kontrak
            $opi->tglKirimDt ? date('d/m/Y', strtotime($opi->tglKirimDt)) : '-', // Tanggal Kirim (dari DT)
            $opi->customer_name ?? '-',                 // Customer
            $opi->poCustomer ?? '-',                    // PO Customer
            $opi->noKontrak ?? '-',                     // Nomer Kontrak
            $opi->NoOPI ?? '-',                         // OPI
            $opi->tipeBox ?? '-',                       // Tipe Box
            $opi->wax ?? '-',                           // Wax
            $opi->tipeOrder ?? '-',                     // Tipe Order
            $opi->namaBarang ?? '-',                    // Nama Barang
            $opi->jumlahOrder ?? 0,                     // Qty OPI Pcs
            number_format($opi->gramSheetBoxKontrak ?? 0, 2),             // Gram Kontrak
            number_format($opi->harga_pcs ?? 0, 2),     // Harga Pcs
            number_format($opi->harga_kg ?? 0, 2),      // Harga Kg
            number_format($tonase, 3),                  // Tonase (qty * berat)
            number_format($qtyKirim, 0),                // Qty Kirim
            number_format($tonKirim, 3),                // Ton Kirim
            $tanggalKirim ? date('d/m/Y', strtotime($tanggalKirim)) : "Belum Kirim", // Tanggal Kirim
            number_format($kurangKirim, 0),             // Kurang Kirim
            number_format($tonKurangKirim, 3),          // Ton Kurang Kirim
            $opi->opi_keterangan ?? '-',                // Keterangan
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal Kontrak',
            'Tanggal Kirim',
            'Customer',
            'PO Customer',
            'Nomer Kontrak',
            'OPI',
            'Tipe Box',
            'Wax',
            'Tipe Order',
            'Nama Barang',
            'Qty OPI Pcs',
            'Gram Kontrak',
            'Harga Pcs',
            'Harga Kg',
            'Tonase (Ton)',
            'Qty Kirim',
            'Ton Kirim',
            'Tanggal Kirim',
            'Kurang Kirim',
            'Ton Kurang Kirim',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        $monthName = Carbon::createFromDate($this->year, $this->month, 1)->format('F Y');
        return 'Intake ' . $monthName;
    }

    public function styles(Worksheet $sheet)
    {
        // Style header row
        $sheet->getStyle('A1:S1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E86AB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Add borders to all data cells
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:S' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Center align date and categorical columns
        $sheet->getStyle('A2:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2:F' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H2:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('P2:P' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Right align numeric columns
        $sheet->getStyle('K2:K' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('L2:L' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M2:M' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('N2:N' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('O2:O' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('Q2:Q' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('R2:R' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }
}