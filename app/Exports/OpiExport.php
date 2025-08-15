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
                'dt' => $item->dt->tglKirimDt,
                'qty_kirim' => $item->jumlahOrder,
                'customer' => $item->kontrakm->customer_name,
                'namaBarang' => $item->mc->namaBarang,
                'qtyOrder' => $item->kontrakd->jumlahOrder,
                'sisaQtyOrder' => $item->jumlahOrder,
                'keteranganOpi' => $item->kontrakm->keterangan,
                'opi' => $item->NoOPI,
                'poCustomer' => $item->kontrakm->poCustomer,
                'noMc' => $item->mc->kode . ($item->mc->revisi == 'R0' ? '' : '-' . $item->mc->revisi),
                'hari' => Carbon::parse($item->dt->tglKirimDt)->translatedFormat('l'),
                'flute' => $item->mc->flute,
                'bentuk' => $item->mc->tipeBox,
                'sheetP' => $item->mc->panjangSheet,
                'sheetL' => $item->mc->lebarSheet,
                'out' => $item->mc->outConv,
                'ukRoll' => '',
                'tipeOrder' => $item->kontrakm->tipeOrder,
                'warna' => $item->mc->colorcombine->nama,
                'finishing' => $item->mc->joint,
                'kualitasProduksiKMAtas' => $item->mc->substancekontrak->lineratas->jenisKertasMc == "BK" ? "K" : $item->mc->substancekontrak->lineratas->jenisKertasMc,
                'kualitasProduksiI1' => $item->mc->substancekontrak->lineratas->gramKertas ?? '',
                'kualitasProduksiI2' => $item->mc->substancekontrak->flute1->gramKertas ?? '',
                'kualitasProduksiI3' => $item->mc->substancekontrak->linertengah->gramKertas ?? '',
                'kualitasProduksiI4' => $item->mc->substancekontrak->flute2->gramKertas ?? '',
                'kualitasProduksiI5' => $item->mc->substancekontrak->linerbawah->gramKertas ?? '',
                'kualitasProduksiKMBawah' => $item->mc->substancekontrak->linerbawah->jenisKertasMc == "BK" ? "K" : $item->mc->substancekontrak->linerbawah->jenisKertasMc,
                'wax' => $item->mc->wax,
                'gram' => $item->mc->gramSheetBoxProduksi,
                'tanggalOrder' => $item->kontrakm->tglKontrak,
                'alamat' => $item->kontrakm->alamatKirim,
                'toleransi' => $item->kontrakd->pctToleransiKurangKontrak.'% '.$item->kontrakd->pctToleransiLebihKontrak.'%',
                'boxP' => $item->mc->box->panjangDalamBox,
                'boxL' => $item->mc->box->lebarDalamBox,
                'boxT' => $item->mc->box->tinggiDalamBox,
                'koli' => $item->mc->koli,
                'dtPerubahan' => $item->dt->tglKirimDt,
                'hargaKg' => $item->kontrakd->hargaKg,
                'realKirim' => '-',
                'sisaDt' => '-',
                'status' => '-',
                'noKontrakUrut' => $item->kontrakm->kode,
                'tglKontrak' => $item->kontrakm->tglKontrak,
                'kualitasKontrakKMAtas' => $item->mc->substanceproduksi->lineratas->jenisKertasMc == "BK" ? "K" : $item->mc->substanceproduksi->lineratas->jenisKertasMc,
                'kualitasKontrakI1' => $item->mc->substanceproduksi->lineratas->gramKertas ?? '',
                'kualitasKontrakI2' => $item->mc->substanceproduksi->flute1->gramKertas ?? '',
                'kualitasKontrakI3' => $item->mc->substanceproduksi->linertengah->gramKertas ?? '',
                'kualitasKontrakI4' => $item->mc->substanceproduksi->flute2->gramKertas ?? '',
                'kualitasKontrakI5' => $item->mc->substanceproduksi->linerbawah->gramKertas ?? '',
                'kualitasKontrakKMBawah' => $item->mc->substanceproduksi->linerbawah->jenisKertasMc == "BK" ? "K" : $item->mc->substanceproduksi->linerbawah->jenisKertasMc,
                'kodeBarang' => $item->mc->kodeBarang,
                'tipeCrease' => $item->mc->box->tipeCreaseCorr,
                'bungkus' => $item->mc->bungkus,
                'lainLain' => $item->mc->lain,
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
            "Lain-Lain"
        ]; 
    }
}
