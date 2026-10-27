<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OpiExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $opi;

    public function __construct($opi)
    {
        $this->opi = $opi;
    }

    public function collection()
    {
        $items = method_exists($this->opi, 'getCollection')
            ? $this->opi->getCollection()
            : collect($this->opi);

        return $items->map(function ($item) {
            return [
                'ID' => $item->id,
                'OPI' => $item->NoOPI,
                'action' => $item->status_opi == 'Proses' ? 'Proses' : 'Complete',
                'kontrak' => $item->kontrakm->kode,
                'opi_ke' => $item->created_at,
                'dt' => Carbon::parse($item->dt->tglKirimDt)->format('d/m/Y'),
                'qty_kirim' => $item->jumlahOrder,
                'customer' => $item->kontrakm->customer_name,
                'namaBarang' => $item->kontrakd->mc->namaBarang,
                'qtyOrder' => $item->kontrakd->jumlahOrder,
                'sisaQtyOrder' => $item->jumlahOrder,
                'keteranganOpi' => $item->keterangan != '' ? $item->kontrakm->keterangan . ', ' .$item->keterangan : $item->kontrakm->keterangan,
                'opi' => $item->NoOPI,
                'poCustomer' => $item->kontrakm->poCustomer,
                'noMc' => $item->kontrakd->mc->kode . ($item->kontrakd->mc->revisi == 'R0' ? '' : '-' . $item->kontrakd->mc->revisi),
                'hari' => Carbon::parse($item->dt->tglKirimDt)->translatedFormat('l'),
                'flute' => $item->kontrakd->mc->flute,
                'bentuk' => $item->kontrakd->mc->tipeBox,
                'sheetP' => $item->kontrakd->mc->panjangSheet,
                'sheetL' => $item->kontrakd->mc->lebarSheet,
                'out' => $item->kontrakd->mc->outConv,
                'ukRoll' => '',
                'tipeOrder' => $item->kontrakm->tipeOrder,
                'warna' => $item->kontrakd->mc->colorcombine->nama,
                'finishing' => $item->kontrakd->mc->joint,
                'kualitasKontrakKMAtas' => isset($item->kontrakd->mc->substanceproduksi->lineratas)
                    ? ($item->kontrakd->mc->substanceproduksi->lineratas->jenisKertasMc == "BK" ? "K" : $item->kontrakd->mc->substanceproduksi->lineratas->jenisKertasMc)
                    : '-',
                'kualitasKontrakI1' => $item->kontrakd->mc->substanceproduksi->lineratas->gramKertas ?? '',
                'kualitasKontrakI2' => $item->kontrakd->mc->substanceproduksi->flute1->gramKertas ?? '',
                'kualitasKontrakI3' => $item->kontrakd->mc->substanceproduksi->linertengah->gramKertas ?? '',
                'kualitasKontrakI4' => $item->kontrakd->mc->substanceproduksi->flute2->gramKertas ?? '',
                'kualitasKontrakI5' => $item->kontrakd->mc->substanceproduksi->linerbawah->gramKertas ?? '',
                'kualitasKontrakKMBawah' => isset($item->kontrakd->mc->substanceproduksi->linerbawah)
                    ? ($item->kontrakd->mc->substanceproduksi->linerbawah->jenisKertasMc == "BK" ? "K" : $item->kontrakd->mc->substanceproduksi->linerbawah->jenisKertasMc)
                    : '-',
                'wax' => $item->kontrakd->mc->wax,
                'gram' => $item->kontrakd->mc->gramSheetBoxProduksi,
                'tanggalOrder' => $item->kontrakm->tglKontrak,
                'alamat' => $item->kontrakm->alamatKirim,
                'toleransi' => $item->kontrakd->pctToleransiKurangKontrak.'% '.$item->kontrakd->pctToleransiLebihKontrak.'%',
                'boxP' => $item->kontrakd->mc->box->panjangDalamBox,
                'boxL' => $item->kontrakd->mc->box->lebarDalamBox,
                'boxT' => $item->kontrakd->mc->box->tinggiDalamBox,
                'koli' => $item->kontrakd->mc->koli,
                'dtPerubahan' => Carbon::parse($item->dt->tglKirimDt)->format('d/m/Y'),
                'hargaKg' => $item->kontrakd->hargaKg,
                'realKirim' => '-',
                'sisaDt' => '-',
                'status' => '-',
                'noKontrakUrut' => $item->kontrakm->kode,
                'tglKontrak' => $item->kontrakm->tglKontrak,
                'kualitasProduksiKMAtas' => isset($item->kontrakd->mc->substancekontrak->lineratas)
                    ? ($item->kontrakd->mc->substancekontrak->lineratas->jenisKertasMc == "BK" ? "K" : $item->kontrakd->mc->substancekontrak->lineratas->jenisKertasMc)
                    : '-',
                'kualitasProduksiI1' => $item->kontrakd->mc->substancekontrak->lineratas->gramKertas ?? '',
                'kualitasProduksiI2' => $item->kontrakd->mc->substancekontrak->flute1->gramKertas ?? '',
                'kualitasProduksiI3' => $item->kontrakd->mc->substancekontrak->linertengah->gramKertas ?? '',
                'kualitasProduksiI4' => $item->kontrakd->mc->substancekontrak->flute2->gramKertas ?? '',
                'kualitasProduksiI5' => $item->kontrakd->mc->substancekontrak->linerbawah->gramKertas ?? '',
                'kualitasProduksiKMBawah' => isset($item->kontrakd->mc->substancekontrak->linerbawah)
                    ? ($item->kontrakd->mc->substancekontrak->linerbawah->jenisKertasMc == "BK" ? "K" : $item->kontrakd->mc->substancekontrak->linerbawah->jenisKertasMc)
                    : '-',
                'kodeBarang' => $item->kontrakd->mc->kodeBarang,
                'tipeCrease' => $item->kontrakd->mc->box->tipeCreaseCorr,
                'bungkus' => $item->kontrakd->mc->bungkus,
                'lainLain' => $item->kontrakd->mc->lain,
                'blok' => $item->kontrakd->mc->text,
                'FSC' => $item->kontrakd->mc->fsc == 1 ? 'FSC' : 'Non FSC',
                'Sales' => $item->kontrakm->sales,
            ];
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Kolom C = Status; baris 1 adalah heading
                for ($row = 2; $row <= $lastRow; $row++) {
                    $status = strtolower(trim((string) $sheet->getCell('C' . $row)->getValue()));

                    $color = $status === 'proses' ? '198754' : ($status === 'closed' ? '0D6EFD' : null);

                    if ($color) {
                        $style = $sheet->getStyle('C' . $row);
                        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
                        $style->getFont()->getColor()->setRGB('FFFFFF');
                    }
                }
            },
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'OPI',
            'Status',
            'Kontrak',
            'OPI Ke',
            'DT',
            'Qty Kirim',
            'Customer',
            'Nama Barang',
            'Qty Order',
            'Sisa Qty Order',
            'Keterangan OPI',
            'OPI',
            'PO Customer',
            'No MC',
            'Hari',
            'Flute',
            'Bentuk',
            'Sheet P',
            'Sheet L',
            'Out Conv',
            'Uk Roll',
            'Tipe Order',
            'Warna',
            'Finishing',
            'Kualitas Produksi KM Atas',
            'Kualitas Produksi I1',
            'Kualitas Produksi I2',
            'Kualitas Produksi I3',
            'Kualitas Produksi I4',
            'Kualitas Produksi I5',
            'Kualitas Produksi KM Bawah',
            'Wax',
            'Gram',
            'Tanggal Order',
            'Alamat',
            'Toleransi (%)',
            'Box P (cm)',
            'Box L (cm)',
            'Box T (cm)',
            'Koli',
            'DT Perubahan (tgl)',
            'Harga/Kg (Rp)',
            'Real Kirim (Kg)',
            'Sisa DT (Kg)',
            'Status OPI',
            'No Kontrak Urut',
            'Tgl Kontrak',
            'Kualitas Kontrak KM Atas',
            'Kualitas Kontrak I1',
            'Kualitas Kontrak I2',
            'Kualitas Kontrak I3',
            'Kualitas Kontrak I4',
            'Kualitas Kontrak I5',
            'Kualitas Kontrak KM Bawah',
            'Kode Barang',
            "Tipe Crease",
            "Bungkus",
            "Lain-Lain",
            "Blok",
            "FSC",
            "Sales"
        ];
    }
}
