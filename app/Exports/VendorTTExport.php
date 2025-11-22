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
    }    
    
    public function collection()
    {   
        // Jika $vendortt adalah query builder, ambil datanya dulu
        if (method_exists($this->vendortt, 'get')) {
            $data = $this->vendortt->get();
        } else {
            $data = $this->vendortt;
        }
        
        return $data->map(function ($item, $index) {
            return [
                'bbm_no' => $item->BBMNo ?? '',
                'tanggal_tt' => $item->master_vend && $item->master_vend->Tglterima 
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(Carbon::parse($item->master_vend->Tglterima)) 
                    : null,
                'no_tt' => $item->NoTT ?? '',
                'bbm_no2' => $item->BBMNo ?? '',
                'supplier' => $item->master_vend->SupplierName ?? '',
                'po_number' => $item->PONumber ?? '',
                'amount' => $item->Amount ?? '0.00',
                'bbm_amount' => $item->BBMAmount ?? '0.00',
                'invoice_number' => $item->InvNumber ?? '',
                'ref_ppn' => $item->RefPPN ?? '',
                'tanggal_ppn' => $item->tglPPN 
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(Carbon::parse($item->tglPPN)) 
                    : null,
            ];
        });
    }
    
    public function headings(): array
    {
        return [
            'BBM No',
            'Tanggal TT',
            'No TT',
            'BBM No',
            'Supplier',
            'PO Number',
            'Amount',
            'BBM Amount',
            'Invoice Number',
            'Ref PPN',
            'Tanggal PPN',
        ];
    }
}
