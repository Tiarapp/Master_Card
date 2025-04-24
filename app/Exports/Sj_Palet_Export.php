<?php

namespace App\Exports;

use App\Models\SJ_Palet_D;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Sj_Palet_Export implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection(): Collection
    {
        $sj = SJ_Palet_D::with('master_palet')->whereHas('master_palet', function ($query) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        })
        ->get();

        if ($sj->isEmpty()) {
            logger()->info('No data found for the given date range.');
            return collect([]); // Return empty collection
        }

        return $sj->map(function ($data) {
                logger()->info('Mapping user data:', $data->toArray());
                    return [
                        'tanggal' => $data->master_palet->tanggal,
                        'nosj' => $data->master_palet->noSuratJalan,
                        'cust' => $data->master_palet->namaCustomer,
                        'nopol' => $data->master_palet->noPolisi,
                        'ukuran' => $data->ukuran,
                        'qty' => $data->qty,
                        'alamat' => $data->master_palet->alamatCustomer
                    ];
                });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Bukti',
            'Customer',
            'No Polisi',
            'Palet',
            'Quantity',
            'Alamat Customer'
        ];
    }
}
