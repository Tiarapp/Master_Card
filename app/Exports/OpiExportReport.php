<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OpiExportReport implements FromCollection, WithHeadings, WithMapping
{
    protected $opi;

    public function __construct(Collection $opi)
    {
        $this->opi = $opi;
    }

    public function collection()
    {
        return $this->opi;
    }

    public function headings(): array
    {
        return [
            'Nomor OPI',
            'Customer',
            'Nama Barang',
            'Tipe Box',
            'Flute',
            'Harga per Kg',
            'Nomor Kontrak',
            'Tgl Kontrak',
            'Qty OPI (pcs)',
            'Qty OPI (kg)',
            'Tanggal Estimasi Kirim',
            'Tanggal Kirim',
            'Qty Realisasi (pcs)',
            'Qty Realisasi (kg)',
        ];
    }

    public function map($opi): array
    {
        $gram = $opi->mc->gramSheetBoxKontrak2 ?? null;

        return [
            $opi->NoOPI,
            $opi->kontrakm->customer_name ?? '',
            $opi->mc->namaBarang ?? '',
            $opi->mc->tipeBox ?? '',
            $opi->mc->flute ?? '',
            $opi->kontrakd->harga_kg ?? '',
            $opi->kontrakm->kode ?? '',
            !empty($opi->kontrakm->tglKontrak) ? Carbon::parse($opi->kontrakm->tglKontrak)->format('d-m-Y') : '',
            $opi->jumlahOrder,
            $gram ? round($opi->jumlahOrder * $gram, 2) : '',
            $opi->tglKirimDt ? Carbon::parse($opi->tglKirimDt)->format('d-m-Y') : '',
            $opi->tanggal_realisasi ? Carbon::parse($opi->tanggal_realisasi)->format('d-m-Y') : '',
            $opi->total_qty_realisasi ?? 0,
            round($opi->total_kg_realisasi ?? 0, 2),
        ];
    }
}
