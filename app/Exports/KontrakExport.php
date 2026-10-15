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

    public function __construct($startDate = null, $endDate = null, $search = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $query = Kontrak_M::with([
            'kontrak_d.mc:id,namaBarang,gramSheetBoxKontrak',
            'kontrak_d:kontrak_m_id,mc_id,pcsKontrak,kgKontrak,harga_pcs,amountTotal',
            'realisasi:kontrak_m_id,tanggal_kirim,qty_kirim'
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

            $tanggalKirim = $realisasiKirim
                ->pluck('tanggal_kirim')
                ->filter()
                ->map(fn ($tanggal) => \Carbon\Carbon::parse($tanggal)->format('d/m/Y'))
                ->unique()
                ->implode(', ');

            $exportData[] = [
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
                $totalRealisasiQty,
                $sisaKontrakQty >= 0 ? $sisaKontrakQty : 0,
                $sisaKontrakKg >= 0 ? number_format($sisaKontrakKg, 2, '.', '') : 0
            ];
        }

        return $exportData;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
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
    }

    public function columnFormats(): array
    {
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
