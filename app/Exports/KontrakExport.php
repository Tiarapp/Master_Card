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
            'kontrak_d.mc:id,namaBarang,gramSheetBoxKontrak,tipeBox',
            'kontrak_d:kontrak_m_id,mc_id,pcsKontrak,kgKontrak,harga_pcs,amountTotal',
            'realisasi:kontrak_m_id,opi_id,tanggal_kirim,qty_kirim',
            'opis' => function ($q) {
                $q->select('id', 'kontrak_m_id', 'NoOPI', 'status_opi', 'jumlahOrder');

                if ($this->exportType === 'opi') {
                    $q->whereIn('status_opi', ['closed', 'Proses']);
                }
            }
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
            $totalNominal = $this->exportType === 'opi'
                ? 0
                : ($kontrakDetail->amountTotal ?? $kontrak->amountTotal ?? 0);
            $rupiahPerKg = $gram > 0 ? $hargaPcs / $gram : 0;

            // Hitung sisa kontrak
            $sisaKontrakQty = $qtyKontrak - $totalRealisasiQty;
            $sisaKontrakKg = $beratKontrak - ($totalRealisasiQty * ($beratKontrak / max($qtyKontrak, 1)));

            $opis = $this->exportType === 'opi'
                ? $kontrak->opis->whereIn('status_opi', ['closed', 'Proses'])
                : [null];

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
                $qtyDisplay = $opi ? ($opi->jumlahOrder ?? 0) : $qtyKontrak;
                $beratDisplay = $opi ? $qtyDisplay * $gram : $beratKontrak;
                $sisaQtyDisplay = $opi
                    ? max($qtyDisplay - $qtyKirim, 0)
                    : max($sisaKontrakQty, 0);
                $sisaKgDisplay = $opi
                    ? max($beratDisplay - ($qtyKirim * $gram), 0)
                    : max($sisaKontrakKg, 0);
                $totalNominalDisplay = $opi
                    ? 0
                    : $totalNominal;
                $hasOpiRealisasi = $opi && $realisasiPerOpi->isNotEmpty();
                $firstRealisasi = $hasOpiRealisasi ? $realisasiPerOpi->first() : null;
                $tanggalKirimDisplay = $firstRealisasi
                    ? ($firstRealisasi->tanggal_kirim
                        ? \Carbon\Carbon::parse($firstRealisasi->tanggal_kirim)->format('d/m/Y')
                        : '-')
                    : ($tanggalKirim ?: '-');
                $qtyKirimDisplay = $firstRealisasi
                    ? ($firstRealisasi->qty_kirim ?? 0)
                    : $qtyKirim;
                $beratKirimDisplay = $firstRealisasi
                    ? number_format(($firstRealisasi->qty_kirim ?? 0) * $gram, 3, '.', '')
                    : number_format($qtyKirim * $gram, 3, '.', '');

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
                    $kontrak->kontrak_d->mc->tipeBox ?? '-',
                    number_format($gram, 3, '.', ''),
                    $qtyDisplay,
                    number_format($beratDisplay, 2, '.', ''),
                    $hargaPcs,
                    $rupiahPerKg,
                    $totalNominalDisplay,
                    $tanggalKirimDisplay,
                    $qtyKirimDisplay,
                    $beratKirimDisplay,
                    $sisaQtyDisplay,
                    number_format($sisaKgDisplay, 3, '.', '')
                ];

                if ($this->exportType === 'opi') {
                    array_splice($row, 13, 1);
                }

                if ($opi) {
                    array_splice($row, 1, 0, [$opi->NoOPI ?? '-', $opi->status_opi ?? '-']);
                }

                $exportData[] = $row;

                if ($hasOpiRealisasi) {
                    foreach ($realisasiPerOpi->skip(1) as $realisasi) {
                        $detailRow = array_fill(0, count($row), '');
                        $detailRow[15] = $realisasi->tanggal_kirim
                            ? \Carbon\Carbon::parse($realisasi->tanggal_kirim)->format('d/m/Y')
                            : '-';
                        $detailRow[16] = $realisasi->qty_kirim ?? 0;
                        $detailRow[17] = number_format(
                            ($realisasi->qty_kirim ?? 0) * $gram,
                            3,
                            '.',
                            ''
                        );
                        $exportData[] = $detailRow;
                    }
                }
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
            'Tipe Box',
            'Gram',
            $this->exportType === 'opi' ? 'Qty OPI' : 'Qty Kontrak',
            $this->exportType === 'opi' ? 'Berat Qty OPI (Kg)' : 'Berat Kontrak (Kg)',
            'Harga per Pcs',
            'Rupiah per Kg',
            'Total Nominal Penjualan',
            'Tanggal Kirim',
            'Quantity Kirim',
            $this->exportType === 'opi' ? 'Berat Kirim OPI (Kg)' : 'Berat Kontrak (Kg)',
            $this->exportType === 'opi' ? 'Sisa OPI (Qty)' : 'Sisa Kontrak (Qty)',
            $this->exportType === 'opi' ? 'Sisa OPI (Kg)' : 'Sisa Kontrak (Kg)'
        ];

        if ($this->exportType === 'opi') {
            array_splice($headings, 13, 1);
            array_splice($headings, 1, 0, ['No OPI', 'Status OPI']);
        }

        return $headings;
    }

    public function columnFormats(): array
    {
        if ($this->exportType === 'opi') {
            return [
                // 'M' => self::FORMAT_ACCOUNTING_IDR,
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
