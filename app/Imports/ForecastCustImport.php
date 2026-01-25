<?php

namespace App\Imports;

use App\Models\ForecastCust;
use App\Models\Sales;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;

class ForecastCustImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find sales by name
        $sales = Sales::where('nama', 'LIKE', '%' . trim($row['sales_name']) . '%')
                     ->where(function($query) {
                         $query->where('aktif', '!=', 2);
                     })
                     ->first();

        $results = collect();
        
        // Process all 12 months from the pivot row
        $months = [
            1 => 'jan_target',
            2 => 'feb_target', 
            3 => 'mar_target',
            4 => 'apr_target',
            5 => 'may_target',
            6 => 'jun_target',
            7 => 'jul_target',
            8 => 'aug_target',
            9 => 'sep_target',
            10 => 'oct_target',
            11 => 'nov_target',
            12 => 'dec_target'
        ];

        foreach ($months as $month => $columnName) {
            $targetTonase = isset($row[$columnName]) ? (float)$row[$columnName] : 0;
            
            // Skip if target is 0 or empty
            if ($targetTonase <= 0) {
                continue;
            }

            // Check if forecast already exists
            $existing = ForecastCust::where('customer_name', trim($row['customer_name']))
                ->where('bulan', $month)
                ->where('tahun', (int)$row['tahun'])
                ->first();

            if ($existing) {
                // Update existing record
                $existing->update([
                    'sales_id' => $sales ? $sales->id : null,
                    'target_tonase' => $targetTonase,
                    'updated_by' => Auth::user()->name ?? 'Import System'
                ]);
            } else {
                // Create new record
                ForecastCust::create([
                    'customer_name' => trim($row['customer_name']),
                    'sales_id' => $sales ? $sales->id : null,
                    'bulan' => $month,
                    'tahun' => (int)$row['tahun'],
                    'target_tonase' => $targetTonase,
                    'keterangan' => '',
                    'created_by' => Auth::user()->name ?? 'Import System',
                    'updated_by' => Auth::user()->name ?? 'Import System'
                ]);
            }
        }

        return null; // We handle creation manually above
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'sales_name' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020',
            'jan_target' => 'nullable|numeric|min:0',
            'feb_target' => 'nullable|numeric|min:0',
            'mar_target' => 'nullable|numeric|min:0',
            'apr_target' => 'nullable|numeric|min:0',
            'may_target' => 'nullable|numeric|min:0',
            'jun_target' => 'nullable|numeric|min:0',
            'jul_target' => 'nullable|numeric|min:0',
            'aug_target' => 'nullable|numeric|min:0',
            'sep_target' => 'nullable|numeric|min:0',
            'oct_target' => 'nullable|numeric|min:0',
            'nov_target' => 'nullable|numeric|min:0',
            'dec_target' => 'nullable|numeric|min:0'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'customer_name.required' => 'Nama customer harus diisi',
            'sales_name.required' => 'Nama sales harus diisi',
            'tahun.required' => 'Tahun harus diisi',
            'tahun.min' => 'Tahun minimal 2020',
            '*.numeric' => 'Target tonase harus berupa angka',
            '*.min' => 'Target tonase tidak boleh negatif',
        ];
    }
}
