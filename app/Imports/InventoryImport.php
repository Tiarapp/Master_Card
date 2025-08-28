<?php

namespace App\Imports;

use App\Models\Inventory;
use App\Models\SupplierRoll;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InventoryImport
{
    private $importedCount = 0;
    private $skippedCount = 0;
    private $errors = [];

    public function import($filePath)
    {
        try {
            // Load spreadsheet langsung menggunakan PhpSpreadsheet
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Ambil data header (baris pertama)
            $headers = [];
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $headerValue = trim($worksheet->getCell($columnLetter . '1')->getValue());
                if (!empty($headerValue)) {
                    $headers[$headerValue] = $columnLetter;
                }
            }
            
            Log::info('Excel headers found for import', $headers);
            
            // Validasi header yang diperlukan
            $requiredHeaders = ['tanggal_masuk', 'kode_internal', 'supplier_id'];
            foreach ($requiredHeaders as $required) {
                if (!isset($headers[$required])) {
                    throw new \Exception("Kolom \"$required\" tidak ditemukan di file Excel");
                }
            }
            
            // Proses setiap baris data (mulai dari baris 2)
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    $kodeInternal = trim($worksheet->getCell($headers['kode_internal'] . $row)->getValue());
                    
                    if (empty($kodeInternal)) {
                        continue; // Skip baris kosong
                    }
                    
                    // Cek apakah inventory sudah ada
                    $existingInventory = Inventory::where('kode_internal', $kodeInternal)->first();
                    
                    if ($existingInventory) {
                        $this->skippedCount++;
                        Log::warning('Inventory already exists', ['kode_internal' => $kodeInternal]);
                        continue;
                    }
                    
                    // Siapkan data untuk import
                    $inventoryData = [];
                    
                    // Field wajib
                    $inventoryData['kode_internal'] = $kodeInternal;
                    
                    // Tanggal masuk
                    $tanggalMasuk = $this->processDateField($worksheet, $headers, $row, 'tanggal_masuk');
                    if ($tanggalMasuk) {
                        $inventoryData['tanggal_masuk'] = $tanggalMasuk;
                    }
                    
                    // Supplier ID
                    $supplierId = $this->processSupplierField($worksheet, $headers, $row, 'supplier_id');
                    if ($supplierId) {
                        $inventoryData['supplier_id'] = $supplierId;
                    }
                    
                    // Field lainnya
                    $this->processField($worksheet, $headers, $row, 'kw', 'kw', $inventoryData);
                    $this->processField($worksheet, $headers, $row, 'jenis', 'jenis', $inventoryData);
                    $this->processField($worksheet, $headers, $row, 'gsm', 'gsm', $inventoryData, 'float');
                    $this->processField($worksheet, $headers, $row, 'kode_roll', 'kode_roll', $inventoryData);
                    $this->processField($worksheet, $headers, $row, 'lebar', 'lebar', $inventoryData, 'float');
                    $this->processField($worksheet, $headers, $row, 'berat_sj', 'berat_sj', $inventoryData, 'float');
                    $this->processField($worksheet, $headers, $row, 'berat_timbang', 'berat_timbang', $inventoryData, 'float');
                    $this->processField($worksheet, $headers, $row, 'quantity', 'quantity', $inventoryData, 'float');
                    $this->processField($worksheet, $headers, $row, 'purchase_order', 'purchase_order', $inventoryData);
                    $this->processField($worksheet, $headers, $row, 'description', 'descoription', $inventoryData);
                    
                    // Set default values
                    $inventoryData['status_roll_id'] = 1; // Default status
                    
                    // Jika quantity tidak diisi, gunakan berat_timbang
                    if (!isset($inventoryData['quantity']) && isset($inventoryData['berat_timbang'])) {
                        $inventoryData['quantity'] = $inventoryData['berat_timbang'];
                    }
                    
                    // Create inventory
                    if (!empty($inventoryData)) {
                        Inventory::create($inventoryData);
                        $this->importedCount++;
                        
                        Log::info('Inventory imported successfully', [
                            'kode_internal' => $kodeInternal,
                            'imported_data' => $inventoryData
                        ]);
                    }
                    
                } catch (\Exception $e) {
                    $this->errors[] = "Error pada baris $row: " . $e->getMessage();
                    Log::error('Row processing error', [
                        'row' => $row,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            $this->errors[] = "Error membaca file: " . $e->getMessage();
            Log::error('File processing error', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    private function processField($worksheet, $headers, $row, $excelColumn, $dbField, &$inventoryData, $type = 'string')
    {
        if (!isset($headers[$excelColumn])) {
            return;
        }
        
        $cellValue = $worksheet->getCell($headers[$excelColumn] . $row)->getValue();
        if ($cellValue !== null && $cellValue !== '') {
            switch ($type) {
                case 'float':
                    $inventoryData[$dbField] = (float) $cellValue;
                    break;
                case 'integer':
                    $inventoryData[$dbField] = (int) $cellValue;
                    break;
                default:
                    $inventoryData[$dbField] = trim($cellValue);
            }
        }
    }
    
    private function processDateField($worksheet, $headers, $row, $excelColumn)
    {
        if (!isset($headers[$excelColumn])) {
            return null;
        }
        
        $cellValue = $worksheet->getCell($headers[$excelColumn] . $row)->getValue();
        
        if ($cellValue === null || $cellValue === '') {
            return null;
        }
        
        try {
            // Jika nilai adalah angka (Excel date serial)
            if (is_numeric($cellValue)) {
                return Date::excelToDateTimeObject($cellValue)->format('Y-m-d');
            }
            
            // Jika nilai adalah string date
            $date = \DateTime::createFromFormat('Y-m-d', $cellValue) ?: 
                    \DateTime::createFromFormat('d/m/Y', $cellValue) ?: 
                    \DateTime::createFromFormat('d-m-Y', $cellValue);
            
            if ($date) {
                return $date->format('Y-m-d');
            }
            
            return null;
        } catch (\Exception $e) {
            Log::warning('Date processing error', [
                'value' => $cellValue,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    private function processSupplierField($worksheet, $headers, $row, $excelColumn)
    {
        if (!isset($headers[$excelColumn])) {
            return null;
        }
        
        $cellValue = $worksheet->getCell($headers[$excelColumn] . $row)->getValue();
        
        if ($cellValue === null || $cellValue === '') {
            return null;
        }
        
        // Jika sudah berupa ID (angka)
        if (is_numeric($cellValue)) {
            $supplier = SupplierRoll::find($cellValue);
            if ($supplier) {
                return $cellValue;
            }
        }
        
        // Jika berupa nama supplier
        $supplier = SupplierRoll::where('name', 'like', '%' . trim($cellValue) . '%')->first();
        if ($supplier) {
            return $supplier->id;
        }
        
        return null;
    }
    
    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
