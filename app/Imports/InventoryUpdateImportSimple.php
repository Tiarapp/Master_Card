<?php

namespace App\Imports;

use App\Models\Inventory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class InventoryUpdateImportSimple implements ToCollection, WithHeadingRow, WithValidation
{
    private $updatedCount = 0;
    private $notFoundCount = 0;
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Cari inventory berdasarkan kode internal
                $inventory = Inventory::where('kode_internal', $row['kode_internal'])->first();
                
                if ($inventory) {
                    // Update field yang tersedia di row
                    $updateData = [];
                    
                    if (isset($row['warna']) && $row['warna'] !== null && $row['warna'] !== '') {
                        $updateData['warna'] = trim($row['warna']);
                    }
                    
                    if (isset($row['gsm_act']) && $row['gsm_act'] !== null && $row['gsm_act'] !== '') {
                        $updateData['gsm_actual'] = (float) $row['gsm_act'];
                    }
                    
                    if (isset($row['cobsize_top']) && $row['cobsize_top'] !== null && $row['cobsize_top'] !== '') {
                        $updateData['cobsize_top'] = (float) $row['cobsize_top'];
                    }
                    
                    if (isset($row['cobsize_back']) && $row['cobsize_back'] !== null && $row['cobsize_back'] !== '') {
                        $updateData['cobsize_bottom'] = (float) $row['cobsize_back'];
                    }
                    
                    if (isset($row['rct_cd']) && $row['rct_cd'] !== null && $row['rct_cd'] !== '') {
                        $updateData['rct_cd'] = number_format((float) $row['rct_cd'], 2, '.', '');
                    }
                    
                    if (isset($row['rct_md']) && $row['rct_md'] !== null && $row['rct_md'] !== '') {
                        $updateData['rct_md'] = number_format((float) $row['rct_md'], 2, '.', '');
                    }
                    
                    // Update inventory jika ada data yang perlu diupdate
                    if (!empty($updateData)) {
                        $inventory->update($updateData);
                        $this->updatedCount++;
                        
                        Log::info('Inventory updated', [
                            'kode_internal' => $row['kode_internal'],
                            'updated_fields' => array_keys($updateData),
                            'updated_data' => $updateData
                        ]);
                    }
                } else {
                    $this->notFoundCount++;
                    $this->errors[] = "Kode Internal '{$row['kode_internal']}' tidak ditemukan";
                    
                    Log::warning('Inventory not found', [
                        'kode_internal' => $row['kode_internal']
                    ]);
                }
            } catch (\Exception $e) {
                $this->errors[] = "Error pada kode internal '{$row['kode_internal']}': " . $e->getMessage();
                Log::error('Import error', [
                    'kode_internal' => $row['kode_internal'] ?? 'unknown',
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'kode_internal' => 'required|string',
            'warna' => 'nullable|string',
            'gsm_act' => 'nullable|numeric',
            'cobsize_top' => 'nullable|numeric',
            'cobsize_back' => 'nullable|numeric',
            'rct_cd' => 'nullable|numeric',
            'rct_md' => 'nullable|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kode_internal.required' => 'Kode Internal wajib diisi',
            'gsm_act.numeric' => 'GSM Act harus berupa angka',
            'cobsize_top.numeric' => 'Cobsize Top harus berupa angka',
            'cobsize_back.numeric' => 'Cobsize Back harus berupa angka',
            'rct_cd.numeric' => 'RCT CD harus berupa angka',
            'rct_md.numeric' => 'RCT MD harus berupa angka',
        ];
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getNotFoundCount()
    {
        return $this->notFoundCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
