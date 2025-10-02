<?php

namespace App\Exports;

use App\Models\Kontrak_M;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KontrakExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
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
            'kontrak_d.mc:id,namaBarang',
            'kontrak_d:kontrak_m_id,mc_id,pcsKontrak,kgKontrak',
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

            // Hitung sisa kontrak
            $sisaKontrakQty = $qtyKontrak - $totalRealisasiQty;
            $sisaKontrakKg = $beratKontrak - ($totalRealisasiQty * ($beratKontrak / max($qtyKontrak, 1)));

            // Jika ada realisasi kirim, buat baris untuk setiap realisasi
            if ($realisasiKirim->count() > 0) {
                foreach ($realisasiKirim as $index => $realisasi) {
                    if ($index === 0) {
                        // Baris pertama dengan semua data kontrak
                        $exportData[] = [
                            $kontrak->kode,
                            \Carbon\Carbon::parse($kontrak->tglKontrak)->format('d/m/Y'),
                            $kontrak->customer_name ?? '-',
                            $kontrak->poCustomer ?? '-',
                            $kontrak->kontrak_d->mc->namaBarang ?? '-',
                            $qtyKontrak,
                            number_format($beratKontrak, 2, '.', ''),
                            \Carbon\Carbon::parse($realisasi->tanggal_kirim)->format('d/m/Y'),
                            $realisasi->qty_kirim,
                            $sisaKontrakQty >= 0 ? $sisaKontrakQty : 0,
                            $sisaKontrakKg >= 0 ? number_format($sisaKontrakKg, 2, '.', '') : 0
                        ];
                    } else {
                        // Baris berikutnya hanya data realisasi
                        $exportData[] = [
                            '', // No Kontrak kosong
                            '', // Tanggal Kontrak kosong
                            '', // Customer kosong
                            '', // PO Customer kosong
                            '', // Nama Barang kosong
                            '', // Qty Kontrak kosong
                            '', // Berat Kontrak kosong
                            \Carbon\Carbon::parse($realisasi->tanggal_kirim)->format('d/m/Y'),
                            $realisasi->qty_kirim,
                            '', // Sisa Kontrak kosong
                            ''  // Sisa Kontrak Kg kosong
                        ];
                    }
                }
            } else {
                // Jika tidak ada realisasi kirim
                $exportData[] = [
                    $kontrak->kode,
                    \Carbon\Carbon::parse($kontrak->tglKontrak)->format('d/m/Y'),
                    $kontrak->customer_name ?? '-',
                    $kontrak->poCustomer ?? '-',
                    $kontrak->kontrak_d->mc->namaBarang ?? '-',
                    $qtyKontrak,
                    number_format($beratKontrak, 2, '.', ''),
                    '-', // Tanggal Kirim
                    '0', // Quantity Kirim
                    $sisaKontrakQty >= 0 ? $sisaKontrakQty : 0,
                    $sisaKontrakKg >= 0 ? number_format($sisaKontrakKg, 2, '.', '') : 0
                ];
            }
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
            'Nama Barang',
            'Qty Kontrak',
            'Berat Kontrak (Kg)',
            'Tanggal Kirim',
            'Quantity Kirim',
            'Sisa Kontrak (Qty)',
            'Sisa Kontrak (Kg)'
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