<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $cust = DB::connection('firebird')->table('TCustomer')->orderBy('Kode', 'asc')->get();
        $count = count($cust);  

        // return response()->json($cust);
        Customer::truncate();
        
        foreach ($cust as $cust) {
            $nestedData['Kode'] = trim($cust->Kode);
            $nestedData['Nama'] = trim($cust->Nama);
            $nestedData['NPWP'] = trim($cust->NPWP);
            $nestedData['AlamatKantor'] = trim($cust->AlamatKantor);
            $nestedData['AlamatKirim'] = trim($cust->AlamatKirim);
            $nestedData['top'] = trim($cust->WAKTUBAYAR);
            $nestedData['plafond'] = trim($cust->Plafond2);
            $nestedData['TelpKantor'] = trim($cust->TelpKantor);
            $nestedData['PIC'] = trim($cust->PIC);
        
            $data[] = $nestedData;
        }
        for ($i=0; $i < count($data) ; $i++) { 
            Customer::create($data[$i]);
        }
    }
}
