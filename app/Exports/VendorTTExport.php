<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class VendorTTExport implements WithHeadings, FromCollection
{
    protected $vendortt;
    protected $rowNumber = 0;

    public function __construct($vendortt)
    {
        $this->vendortt = $vendortt;
    }    public function collection()
    {   
        // Jika $vendortt adalah query builder, ambil datanya dulu
        if (method_exists($this->vendortt, 'get')) {
            $data = $this->vendortt->get();
        } else {
            $data = $this->vendortt;
        }
        
        return $data->map(function ($item, $index) {
            return [
                'tanggal_tt' => $item->master_vend && $item->master_vend->Tglterima 
                    ? Carbon::parse($item->master_vend->Tglterima)->format('d-m-Y') 
                    : '',
                'no_tt' => $item->NoTT ?? '',
                'invoice_number' => $item->InvNumber ?? '',
                'po_number' => $item->PONumber ?? '',
                'waktu_bayar' => $item->top ? $item->top . ' hari' : '-',
                'bbm_no' => $item->BBMNo ?? '',
                'amount' => $item->Amount ? number_format((float) $item->Amount, 2) : '0.00',
                'bbm_amount' => $item->BBMAmount ? number_format((float) $item->BBMAmount, 2) : '0.00',
            ];
        });
    }
    
    public function headings(): array
    {
        return [
            'Tanggal TT',
            'No TT',
            'Invoice Number',
            'PO Number',
            'Waktu Bayar (Hari)',
            'BBM No',
            'Amount',
            'BBM Amount',
        ];
    }
}
