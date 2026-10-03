<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

class SyncFingerAttendance extends Command
{
    protected $signature = 'finger:sync-attendance';
    protected $description = 'Sinkronisasi absensi dari database fingerprint Access';

    public function handle()
    {
        $path = env('FINGER_MDB_PATH');

        if (!$path || !is_readable($path)) {
            $this->error('File MDB tidak ditemukan atau tidak bisa dibaca: ' . $path);
            return 1;
        }

        $process = new Process(['mdb-export', $path, 'CHECKINOUT']);
        $process->setTimeout(1800);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error($process->getErrorOutput() ?: 'Gagal membaca tabel CHECKINOUT.');
            return 1;
        }

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $process->getOutput());
        rewind($stream);

        $headers = fgetcsv($stream);
        if (!$headers) {
            fclose($stream);
            $this->error('Tabel CHECKINOUT kosong atau tidak dapat dibaca.');
            return 1;
        }

        $headers = array_map(function ($header) {
            return strtoupper(trim(preg_replace('/^\xEF\xBB\xBF/', '', $header)));
        }, $headers);

        $indexes = array_flip($headers);
        foreach (['USERID', 'CHECKTIME', 'CHECKTYPE'] as $column) {
            if (!isset($indexes[$column])) {
                fclose($stream);
                $this->error("Kolom {$column} tidak ditemukan di CHECKINOUT.");
                return 1;
            }
        }

        $batch = [];
        $read = 0;
        $valid = 0;
        $invalid = 0;
        $inserted = 0;
        $ignored = 0;

        while (($row = fgetcsv($stream)) !== false) {
            $read++;

            $userId = trim($row[$indexes['USERID']] ?? '');
            $rawCheckTime = trim($row[$indexes['CHECKTIME']] ?? '');
            if ($userId === '' || $rawCheckTime === '') {
                $invalid++;
                continue;
            }

            try {
                $checkTime = Carbon::parse($rawCheckTime)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $invalid++;
                continue;
            }

            $checkType = trim($row[$indexes['CHECKTYPE']] ?? '');

            $batch[] = [
                'source_user_id' => $userId,
                'check_time' => $checkTime,
                'check_type' => $checkType ?: null,
                'source_key' => hash('sha256', $userId . '|' . $checkTime . '|' . $checkType),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $valid++;

            if (count($batch) >= 500) {
                $affected = DB::table('finger_attendances')->insertOrIgnore($batch);
                $inserted += $affected;
                $ignored += count($batch) - $affected;
                $batch = [];
            }
        }

        if ($batch) {
            $affected = DB::table('finger_attendances')->insertOrIgnore($batch);
            $inserted += $affected;
            $ignored += count($batch) - $affected;
        }

        fclose($stream);

        if ($read === 0) {
            $this->error("Tidak ada record absensi pada CHECKINOUT. Periksa apakah path MDB menunjuk ke file yang benar: {$path}");
            return 1;
        }

        $this->info('Database tujuan: ' . DB::connection()->getDatabaseName());
        $this->info("Sinkronisasi selesai. CSV: {$read}; valid: {$valid}; tidak valid: {$invalid}; baru disimpan: {$inserted}; diabaikan: {$ignored}");

        return 0;
    }
}
