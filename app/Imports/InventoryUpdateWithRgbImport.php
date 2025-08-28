<?php

namespace App\Imports;

use App\Models\Inventory;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InventoryUpdateWithRgbImport
{
    private $updatedCount = 0;
    private $notFoundCount = 0;
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
            
            Log::info('Excel headers found', $headers);
            
            // Validasi header yang diperlukan
            if (!isset($headers['kode_internal'])) {
                throw new \Exception('Kolom "kode_internal" tidak ditemukan di file Excel');
            }
            
            // Proses setiap baris data (mulai dari baris 2)
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    $kodeInternal = trim($worksheet->getCell($headers['kode_internal'] . $row)->getValue());
                    
                    if (empty($kodeInternal)) {
                        continue; // Skip baris kosong
                    }
                    
                    // Cari inventory berdasarkan kode_internal
                    $inventory = Inventory::where('kode_internal', $kodeInternal)->first();
                    
                    if (!$inventory) {
                        $this->notFoundCount++;
                        Log::warning('Inventory not found', ['kode_internal' => $kodeInternal]);
                        continue;
                    }
                    
                    // Siapkan data untuk update
                    $updateData = [];
                    
                    // Proses field lainnya dari teks
                    $this->processField($worksheet, $headers, $row, 'warna', 'warna', $updateData);
                    $this->processField($worksheet, $headers, $row, 'gsm(%)', 'gsm_actual', $updateData, 'float');
                    $this->processField($worksheet, $headers, $row, 'gsm_act', 'gsm_actual', $updateData, 'float'); // Alternative header
                    $this->processField($worksheet, $headers, $row, 'gsm_actual', 'gsm_actual', $updateData, 'float'); // Direct header
                    $this->processField($worksheet, $headers, $row, 'cobsize_top', 'cobsize_top', $updateData, 'float');
                    $this->processField($worksheet, $headers, $row, 'cobsize_back', 'cobsize_bottom', $updateData, 'float');
                    $this->processField($worksheet, $headers, $row, 'rct_cd', 'rct_cd', $updateData, 'decimal');
                    $this->processField($worksheet, $headers, $row, 'rct_md', 'rct_md', $updateData, 'decimal');
                    
                    // Proses field warna dari background color (override jika ada warna background)
                    $warnaFromBackground = $this->getRowBackgroundColor($worksheet, $headers, $row);
                    if ($warnaFromBackground !== false) { // Jika ada background color ditemukan
                        $updateData['warna'] = $warnaFromBackground; // Bisa null (untuk white) atau RGB code
                    }
                    
                    // Update inventory jika ada data untuk diupdate
                    if (!empty($updateData)) {
                        $inventory->update($updateData);
                        $this->updatedCount++;
                        
                        Log::info('Inventory updated via RGB import', [
                            'kode_internal' => $kodeInternal,
                            'updated_fields' => array_keys($updateData),
                            'updated_data' => $updateData
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
    
    private function processField($worksheet, $headers, $row, $excelColumn, $dbField, &$updateData, $type = 'string')
    {
        if (!isset($headers[$excelColumn])) {
            return;
        }
        
        $cellValue = $worksheet->getCell($headers[$excelColumn] . $row)->getValue();
        if ($cellValue !== null && $cellValue !== '') {
            switch ($type) {
                case 'float':
                    $updateData[$dbField] = (float) $cellValue;
                    break;
                case 'decimal':
                    $updateData[$dbField] = number_format((float) $cellValue, 2, '.', '');
                    break;
                default:
                    $updateData[$dbField] = trim($cellValue);
            }
        }
    }
    
    private function getCellBackgroundColor($cell)
    {
        try {
            $fill = $cell->getStyle()->getFill();
            
            if ($fill->getFillType() !== Fill::FILL_NONE) {
                $startColor = $fill->getStartColor();
                $rgbValue = $startColor->getRGB();
                
                if ($rgbValue) {
                    // Jika background white, return 'NULL_WHITE' sebagai marker untuk null
                    if ($rgbValue === 'FFFFFF') {
                        return 'NULL_WHITE';
                    }
                    
                    // Abaikan hanya background hitam
                    if ($rgbValue !== '000000') {
                        return $this->formatRgbCode($rgbValue);
                    }
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::warning('Error reading cell background color', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    private function getRowBackgroundColor($worksheet, $headers, $row)
    {
        try {
            // Periksa semua cell di baris ini untuk background color
            foreach ($headers as $headerName => $columnLetter) {
                $cell = $worksheet->getCell($columnLetter . $row);
                $backgroundColor = $this->getCellBackgroundColor($cell);
                if ($backgroundColor) {
                    // Jika background white, return null untuk disimpan sebagai null di database
                    if ($backgroundColor === 'NULL_WHITE') {
                        Log::info('White background color found - will save as null', [
                            'row' => $row,
                            'column' => $headerName
                        ]);
                        return null; // Return null untuk disimpan ke database
                    }
                    
                    Log::info('Background color found', [
                        'row' => $row,
                        'column' => $headerName,
                        'color' => $backgroundColor
                    ]);
                    return $backgroundColor;
                }
            }
            
            return false; // Return false jika tidak ada background color sama sekali
        } catch (\Exception $e) {
            Log::warning('Error reading row background color', [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    private function formatRgbCode($rgbColor)
    {
        // Bersihkan string color
        $rgbColor = strtoupper(trim($rgbColor));
        
        // Hapus alpha channel jika ada (ARGB -> RGB)
        if (strlen($rgbColor) === 8) {
            $rgbColor = substr($rgbColor, 2);
        }
        
        // Pastikan format 6 karakter dan valid hexadecimal
        if (strlen($rgbColor) === 6 && ctype_xdigit($rgbColor)) {
            return '#' . $rgbColor; // Kembalikan dengan format #RRGGBB
        }
        
        // Fallback untuk format yang tidak valid
        return null;
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
