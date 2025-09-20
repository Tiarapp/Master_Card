<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hardware;

class ExportHardware extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hardware:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export hardware data to CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting hardware export...');
        
        try {
            $hardwares = Hardware::orderBy('kode_hardware', 'asc')->get();
            $filename = 'hardware_export_' . date('Y-m-d') . '.csv';
            $filePath = public_path($filename);
            
            $file = fopen($filePath, 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            $headers = [
                'Kode Hardware',
                'Nama Hardware',
                'Merk',
                'Model',
                'Serial Number',
                'Spesifikasi',
                'Kategori',
                'Status',
                'Tanggal Pembelian',
                'Harga Pembelian',
                'Lokasi',
                'PIC Pengguna',
                'Divisi',
                'Keterangan',
                'Tanggal Garansi Mulai',
                'Tanggal Garansi Selesai',
                'Vendor',
                'No Invoice',
                'Created By',
                'Created At'
            ];
            fputcsv($file, $headers);
            
            // Add data
            foreach ($hardwares as $hardware) {
                $row = [
                    $hardware->kode_hardware,
                    $hardware->nama_hardware,
                    $hardware->merk,
                    $hardware->model,
                    $hardware->serial_number,
                    $hardware->spesifikasi,
                    $hardware->kategori,
                    $hardware->status,
                    $hardware->tanggal_pembelian ? $hardware->tanggal_pembelian->format('Y-m-d') : '',
                    $hardware->harga_pembelian ? 'Rp ' . number_format($hardware->harga_pembelian, 0, ',', '.') : '',
                    $hardware->lokasi,
                    $hardware->pic_pengguna,
                    $hardware->divisi,
                    $hardware->keterangan,
                    $hardware->tanggal_garansi_mulai ? $hardware->tanggal_garansi_mulai->format('Y-m-d') : '',
                    $hardware->tanggal_garansi_selesai ? $hardware->tanggal_garansi_selesai->format('Y-m-d') : '',
                    $hardware->vendor,
                    $hardware->no_invoice,
                    $hardware->created_by,
                    $hardware->created_at ? $hardware->created_at->format('Y-m-d H:i:s') : ''
                ];
                fputcsv($file, $row);
            }
            
            fclose($file);
            
            $this->info("Hardware export completed successfully!");
            $this->info("File saved as: {$filename}");
            $this->info("Total records exported: {$hardwares->count()}");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Export failed: ' . $e->getMessage());
            return 1;
        }
    }
}
