<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OpiRealisasiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $realisasi;

    public function __construct(Collection $realisasi)
    {
        $this->realisasi = $realisasi;
    }

    public function collection()
    {
        return $this->realisasi;
    }

    public function headings(): array
    {
        return [
            'No. OPI',
            'Customer',
            'No. Kontrak',
            'Tanggal Rencana Kirim',
            'Qty OPI (pcs)',
            'Tanggal Realisasi',
            'No. Surat Jalan',
            'Qty Kirim (pcs)',
            'Qty Kirim (kg)',
            'Harga per Kg',
        ];
    }

    public function map($realisasi): array
    {
        $opi = $realisasi->opi;
        $kontrak = $opi ? $opi->kontrakm : $realisasi->kontrakm;
        $kgkirim = $realisasi->qty_kirim * ($opi && $opi->mc && $opi->mc->gramSheetBoxKontrak2 ? round($opi->mc->gramSheetBoxKontrak2, 2) : 0);

        return [
            $opi->NoOPI ?? '',
            $kontrak->customer_name ?? '',
            $kontrak->kode ?? '',
            $opi && $opi->tglKirimDt ? Carbon::parse($opi->tglKirimDt)->format('d-m-Y') : '',
            $opi->jumlahOrder ?? '',
            $realisasi->tanggal_kirim ? Carbon::parse($realisasi->tanggal_kirim)->format('d-m-Y') : '',
            $realisasi->nomer_sj ?? '',
            $realisasi->qty_kirim ?? '',
            $kgkirim ?? '',
            $opi->kontrakd->harga_kg ?? '',
        ];
    }
}
