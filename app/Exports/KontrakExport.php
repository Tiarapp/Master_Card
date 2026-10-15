<?php

namespace App\Exports;

use App\Models\Kontrak_M;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KontrakExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    private const FORMAT_ACCOUNTING_IDR = '_("Rp"* #,##0.00_);_("Rp"* \(#,##0.00\);_("Rp"* "-"??_);_(@_)';

    protected $startDate;
    protected $endDate;
    protected $search;
    protected $exportType;

    public function __construct($startDate = null, $endDate = null, $search = null, $exportType = 'running')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
        $this->exportType = $exportType;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $query = Kontrak_M::with([
            'kontrak_d.mc:id,namaBarang,gramSheetBoxKontrak',
            'kontrak_d:kontrak_m_id,mc_id,pcsKontrak,kgKontrak,harga_pcs,amountTotal',
            'realisasi:kontrak_m_id,opi_id,tanggal_kirim,qty_kirim',
            'opis:id,kontrak_m_id,NoOPI,status_opi'
        ]);

        // Filter berdasarkan tanggal jika ada
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tglKontrak', [$this->startDate, $this->endDate]);
        }

        // Filter berdasarkan search parameter jika ada
        if ($this->search) {
            $query->where(function($q) {
                $q->where('kode', 'like', '%'.$this->search.'%')
                  ->orWhere('customer_name', 'like', '%'.$this->search.'%')
                  ->orWhere('poCustomer', 'like', '%'.$this->search.'%')
                  ->orWhere('sales', 'like', '%'.$this->search.'%');
            })
            ->orWhereHas('kontrak_d.mc', function($query) {
                $query->where('kode', 'like', '%'.$this->search.'%')
                      ->orWhere('namaBarang', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->exportType === 'opi') {
            $query->whereHas('opis', function ($q) {
                $q->whereIn('status_opi', ['closed', 'Proses']);
            });
        }

        $kontrakList = $query->orderBy('tglKontrak', 'desc')->get();

        $exportData = [];

        foreach ($kontrakList as $kontrak) {
            // Ambil data realisasi kirim
            $realisasiKirim = $kontrak->realisasi;

            // Hitung total realisasi
            $totalRealisasiQty = $realisasiKirim->sum('qty_kirim');

            // Ambil data kontrak detail untuk qty dan berat
            $kontrakDetail = $kontrak->kontrak_d;
            $qtyKontrak = $kontrakDetail ? $kontrakDetail->pcsKontrak : 0;
            $beratKontrak = $kontrakDetail ? $kontrakDetail->kgKontrak : 0;
            $gram = $kontrakDetail->mc->gramSheetBoxKontrak ?? 0;
            $hargaPcs = $kontrakDetail->harga_pcs ?? 0;
            $totalNominal = $kontrakDetail->amountTotal ?? $kontrak->amountTotal ?? 0;
            $rupiahPerKg = $gram > 0 ? $hargaPcs / $gram : 0;

            // Hitung sisa kontrak
            $sisaKontrakQty = $qtyKontrak - $totalRealisasiQty;
            $sisaKontrakKg = $beratKontrak - ($totalRealisasiQty * ($beratKontrak / max($qtyKontrak, 1)));

            $opis = $this->exportType === 'opi' ? $kontrak->opis : [null];

            foreach ($opis as $opi) {
                $realisasiPerOpi = $opi
                    ? $realisasiKirim->where('opi_id', $opi->id)
                    : $realisasiKirim;
                $qtyKirim = $realisasiPerOpi->sum('qty_kirim');
                $tanggalKirim = $realisasiPerOpi
                    ->pluck('tanggal_kirim')
                    ->filter()
                    ->map(fn ($tanggal) => \Carbon\Carbon::parse($tanggal)->format('d/m/Y'))
                    ->unique()
                    ->implode(', ');

                $row = [
                    $kontrak->kode,
                    \Carbon\Carbon::parse($kontrak->tglKontrak)->format('d/m/Y'),
                    $kontrak->customer_name ?? '-',
                    $kontrak->poCustomer ?? '-',
                    $kontrak->sales ?? '-',
                    $kontrak->min_tgl_kirim
                        ? \Carbon\Carbon::parse($kontrak->min_tgl_kirim)->format('d/m/Y')
                        : '-',
                    $kontrak->kontrak_d->mc->namaBarang ?? '-',
                    number_format($gram, 2, '.', ''),
                    $qtyKontrak,
                    number_format($beratKontrak, 2, '.', ''),
                    $hargaPcs,
                    $rupiahPerKg,
                    $totalNominal,
                    $tanggalKirim ?: '-',
                    $qtyKirim,
                    $sisaKontrakQty >= 0 ? $sisaKontrakQty : 0,
                    $sisaKontrakKg >= 0 ? number_format($sisaKontrakKg, 2, '.', '') : 0
                ];

                if ($opi) {
                    array_splice($row, 1, 0, [$opi->NoOPI ?? '-', $opi->status_opi ?? '-']);
                }

                $exportData[] = $row;
            }
        }

        return $exportData;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'No Kontrak',
            'Tanggal Kontrak',
            'Customer',
            'PO Customer',
            'Nama Sales',
            'Tanggal Kirim (Est)',
            'Nama Barang',
            'Gram',
            'Qty Kontrak',
            'Berat Kontrak (Kg)',
            'Harga per Pcs',
            'Rupiah per Kg',
            'Total Nominal Penjualan',
            'Tanggal Kirim',
            'Quantity Kirim',
            'Sisa Kontrak (Qty)',
            'Sisa Kontrak (Kg)'
        ];

        if ($this->exportType === 'opi') {
            array_splice($headings, 1, 0, ['No OPI', 'Status OPI']);
        }

        return $headings;
    }

    public function columnFormats(): array
    {
        if ($this->exportType === 'opi') {
            return [
                'M' => self::FORMAT_ACCOUNTING_IDR,
                'N' => self::FORMAT_ACCOUNTING_IDR,
                'O' => self::FORMAT_ACCOUNTING_IDR,
            ];
        }

        return [
            'K' => self::FORMAT_ACCOUNTING_IDR,
            'L' => self::FORMAT_ACCOUNTING_IDR,
            'M' => self::FORMAT_ACCOUNTING_IDR,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '366092']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]
        ];
    }
}
