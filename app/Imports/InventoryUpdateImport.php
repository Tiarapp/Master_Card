<?php

namespace App\Imports;

use App\Models\Inventory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Style\Color;

class InventoryUpdateImport implements ToArray, WithHeadingRow, WithValidation, WithEvents
{
    private $updatedCount = 0;
    private $notFoundCount = 0;
    private $errors = [];
    private $worksheet;
    private $warnaColumnIndex = null;

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $this->worksheet = $event->sheet->getDelegate();
                
                // Cari index kolom warna
                $headerRow = $this->worksheet->getRowIterator(1, 1)->current();
                $cellIterator = $headerRow->getCellIterator();
                $columnIndex = 0;
                
                foreach ($cellIterator as $cell) {
                    $columnIndex++;
                    if (strtolower(trim($cell->getValue())) === 'warna') {
                        $this->warnaColumnIndex = $columnIndex;
                        break;
                    }
                }
            },
        ];
    }

    public function array(array $rows)
    {
        $currentRow = 2; // Mulai dari baris 2 (setelah header)
        
        foreach ($rows[0] as $row) { // rows[0] karena ToArray wraps dalam array
            try {
                // Cari inventory berdasarkan kode internal
                $inventory = Inventory::where('kode_internal', $row['kode_internal'])->first();
                
                if ($inventory) {
                    // Update field yang tersedia di row
                    $updateData = [];
                    
                    // Cek warna dari value cell atau warna background cell
                    $warnaValue = null;
                    if (isset($row['warna']) && $row['warna'] !== null && $row['warna'] !== '') {
                        $warnaValue = trim($row['warna']);
                    } elseif ($this->worksheet && $this->warnaColumnIndex) {
                        // Baca warna background dari cell
                        $warnaValue = $this->getCellColorValue($currentRow, $this->warnaColumnIndex);
                    }
                    
                    if ($warnaValue) {
                        $updateData['warna'] = $warnaValue;
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
            
            $currentRow++; // Increment row counter
        }
    }

    private function getCellColorValue($row, $column)
    {
        try {
            if (!$this->worksheet) {
                Log::warning('Worksheet not available for color reading');
                return null;
            }
            
            // Convert column number to letter (A, B, C, etc.)
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
            $cellCoordinate = $columnLetter . $row;
            
            $cell = $this->worksheet->getCell($cellCoordinate);
            $style = $cell->getStyle();
            $fill = $style->getFill();
            
            Log::info('Reading cell color', [
                'coordinate' => $cellCoordinate,
                'fill_type' => $fill->getFillType(),
                'has_start_color' => $fill->getStartColor() !== null
            ]);
            
            if ($fill->getFillType() !== \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE) {
                $startColor = $fill->getStartColor();
                $colorValue = $startColor->getRGB();
                
                if ($colorValue && $colorValue !== 'FFFFFF' && $colorValue !== '000000') {
                    Log::info('Color detected', [
                        'coordinate' => $cellCoordinate,
                        'rgb' => $colorValue
                    ]);
                    
                    return $this->mapColorToValue($colorValue);
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error reading cell color', [
                'row' => $row,
                'column' => $column,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    private function mapColorToValue($rgbColor)
    {
        // Mapping warna RGB ke nilai warna
        $colorMap = [
            'FF0000' => 'MERAH',     // Red
            '00FF00' => 'HIJAU',     // Green  
            '0000FF' => 'BIRU',      // Blue
            'FFFF00' => 'KUNING',    // Yellow
            'FFA500' => 'ORANGE',    // Orange
            'FFC0CB' => 'PINK',      // Pink
            'A020F0' => 'UNGU',      // Purple
            '000000' => 'HITAM',     // Black
            'FFFFFF' => 'PUTIH',     // White
            'C0C0C0' => 'ABU',       // Silver/Gray
        ];
        
        // Bersihkan string color
        $rgbColor = strtoupper(trim($rgbColor));
        
        // Hapus alpha channel jika ada (ARGB -> RGB)
        if (strlen($rgbColor) === 8) {
            $rgbColor = substr($rgbColor, 2);
        }
        
        // Pastikan format 6 karakter
        if (strlen($rgbColor) === 6 && isset($colorMap[$rgbColor])) {
            return $colorMap[$rgbColor];
        }
        
        // Jika warna tidak dikenali, kembalikan nilai RGB (6 karakter)
        if (strlen($rgbColor) === 6) {
            return 'WARNA_' . $rgbColor;
        }
        
        // Fallback untuk format yang tidak valid
        return 'WARNA_UNKNOWN';
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
