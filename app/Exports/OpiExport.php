<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OpiExport implements FromCollection, WithHeadings
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
        return $this->opi->getCollection()->map(function ($item) {
            return [
                'ID' => $item->id,
                'OPI' => $item->NoOPI,
                'action' => '',
                'kontrak' => $item->kontrakm->kode,
                'opi_ke' => $item->created_at,
                'dt' => Carbon::parse($item->dt->tglKirimDt)->format('d/m/Y'),
                'qty_kirim' => $item->jumlahOrder,
                'customer' => $item->kontrakm->customer_name,
                'namaBarang' => $item->kontrakd->mc->namaBarang,
                'qtyOrder' => $item->kontrakd->jumlahOrder,
                'sisaQtyOrder' => $item->jumlahOrder,
                'keteranganOpi' => $item->kontrakm->keterangan,
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
                'kualitasKontrakKMBawah' => $item->kontrakd->mc->substanceproduksi->linerbawah->jenisKertasMc == "BK" ? "K" : $item->kontrakd->mc->substanceproduksi->linerbawah->jenisKertasMc,
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
                'kualitasProduksiKMBawah' => $item->kontrakd->mc->substancekontrak->linerbawah->jenisKertasMc == "BK" ? "K" : $item->kontrakd->mc->substancekontrak->linerbawah->jenisKertasMc,
                'kodeBarang' => $item->kontrakd->mc->kodeBarang,
                'tipeCrease' => $item->kontrakd->mc->box->tipeCreaseCorr,
                'bungkus' => $item->kontrakd->mc->bungkus,
                'lainLain' => $item->kontrakd->mc->lain,
                'blok' => $item->kontrakd->mc->text,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'OPI',
            'Action',
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
            "Blok"
        ]; 
    }
}
