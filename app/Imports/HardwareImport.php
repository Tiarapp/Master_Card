<?php

namespace App\Imports;

use App\Models\Hardware;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HardwareImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Hardware([
            'kode_hardware' => $row['kode_hardware'],
            'nama_hardware' => $row['nama_hardware'],
            'merk' => $row['merk'] ?? null,
            'model' => $row['model'] ?? null,
            'serial_number' => $row['serial_number'] ?? null,
            'spesifikasi' => $row['spesifikasi'] ?? null,
            'kategori' => $row['kategori'],
            'status' => $row['status'] ?? 'Aktif',
            'tanggal_pembelian' => $this->transformDate($row['tanggal_pembelian'] ?? null),
            'harga_pembelian' => $row['harga_pembelian'] ?? 0,
            'lokasi' => $row['lokasi'] ?? null,
            'pic_pengguna' => $row['pic_pengguna'] ?? null,
            'divisi' => $row['divisi'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
            'tanggal_garansi_mulai' => $this->transformDate($row['tanggal_garansi_mulai'] ?? null),
            'tanggal_garansi_selesai' => $this->transformDate($row['tanggal_garansi_selesai'] ?? null),
            'vendor' => $row['vendor'] ?? null,
            'no_invoice' => $row['no_invoice'] ?? null,
            'created_by' => Auth::user()->name ?? 'System',
        ]);
    }

    public function rules(): array
    {
        return [
            '*.kode_hardware' => 'required|unique:hardware,kode_hardware',
            '*.nama_hardware' => 'required|string|max:255',
            '*.kategori' => 'required|in:Laptop,Desktop,Printer,Server,Network,Monitor,Scanner,Proyektor,Storage,Others',
            '*.status' => 'nullable|in:Aktif,Tidak Aktif,Rusak,Maintenance',
        ];
    }

    private function transformDate($value)
    {
        if (empty($value) || trim($value) === '') {
            return null;
        }

        try {
            // Handle Excel numeric date format (days since 1900-01-01)
            if (is_numeric($value) && $value > 25569) { // Excel date after 1970
                return Carbon::createFromTimestamp(($value - 25569) * 86400)->format('Y-m-d');
            }
            
            // Handle string date formats (YYYY-MM-DD, DD/MM/YYYY, etc.)
            $date = Carbon::parse($value);
            return $date->format('Y-m-d');
            
        } catch (\Exception $e) {
            // Try different date formats
            $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'm-d-Y'];
            
            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $value);
                    return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            return null;
        }
    }
}
