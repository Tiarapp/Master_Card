<?php

namespace App\Services;

use App\Models\Mastercard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MastercardApprovalService
{
    private $approvalPaths = [];

    public function transaction(callable $callback)
    {
        $this->approvalPaths = [];

        try {
            return DB::transaction($callback);
        } catch (\Throwable $exception) {
            foreach ($this->approvalPaths as $path) {
                if (!Storage::disk('local')->delete($path)) {
                    Log::error('Gagal menghapus file approval setelah transaksi gagal.', ['path' => $path]);
                }
            }
            throw $exception;
        }
    }

    public function validate(Request $request, $required = false)
    {
        $request->validate([
            'approval_files' => ($required ? 'required' : 'nullable') . '|array|max:10',
            'approval_files.*' => 'required|file|mimes:pdf,jpeg,jpg|mimetypes:application/pdf,image/jpeg|max:5120',
        ], [
            'approval_files.required' => 'Pilih setidaknya satu file approval.',
            'approval_files.max' => 'Maksimal 10 file approval per penyimpanan.',
            'approval_files.*.mimes' => 'File approval harus berformat PDF atau JPEG/JPG.',
            'approval_files.*.mimetypes' => 'File approval harus berformat PDF atau JPEG/JPG.',
            'approval_files.*.max' => 'Ukuran setiap file approval maksimal 5 MB.',
        ]);
    }

    public function save(Mastercard $mastercard, Request $request, ?Mastercard $source = null)
    {
        if ($source) {
            foreach ($source->approvals as $approval) {
                $mastercard->approvals()->create([
                    'original_name' => $approval->original_name,
                    'path' => $approval->path,
                    'mime_type' => $approval->mime_type,
                ]);
            }
        }

        foreach ($request->file('approval_files', []) as $file) {
            $path = $file->store('mastercard-approvals', 'local');
            if ($path === false) {
                throw new \RuntimeException('Gagal menyimpan file approval.');
            }
            $this->approvalPaths[] = $path;
            $mastercard->approvals()->create([
                'original_name' => mb_substr($file->getClientOriginalName(), 0, 255),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
            ]);
        }
    }
}
