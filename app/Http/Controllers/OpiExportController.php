<?php

namespace App\Http\Controllers;

use App\Exports\OpiHistoryQueuedExport;
use App\Jobs\MarkExportRequestDone;
use App\Models\ExportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OpiExportController extends Controller
{
    private const TYPE = 'opi_history';

    public function store(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date|after_or_equal:date_start',
        ]);
        $filters = array_filter($filters, function ($value) {
            return $value !== null && $value !== '';
        });

        if (config('queue.default') === 'sync') {
            return redirect()->back()->with('error', 'Queue belum aktif (QUEUE_CONNECTION=sync). Ubah ke "database" dan jalankan queue worker.');
        }

        $active = ExportRequest::where('user_id', Auth::id())
            ->where('type', self::TYPE)
            ->whereIn('status', [ExportRequest::PENDING, ExportRequest::PROCESSING])
            ->where('created_at', '>=', now()->subHours(2))
            ->exists();
        if ($active) {
            return redirect()->back()->with('error', 'Masih ada export OPI yang sedang diproses. Tunggu hingga selesai.');
        }

        $fileName = 'opi_history_' . now()->format('Ymd_His') . '.xlsx';
        $exportRequest = ExportRequest::create([
            'user_id' => Auth::id(),
            'type' => self::TYPE,
            'filters' => $filters,
            'status' => ExportRequest::PROCESSING,
            'file_name' => $fileName,
            'file_path' => 'exports/opi/' . Str::uuid() . '.xlsx',
        ]);

        Excel::queue(new OpiHistoryQueuedExport($filters, $exportRequest->id), $exportRequest->file_path, 'local')
            ->chain([new MarkExportRequestDone($exportRequest->id)]);

        return redirect()->back()->with('success', 'Export OPI diproses di latar belakang. Unduh file dari daftar export setelah selesai.');
    }

    public function status()
    {
        $items = ExportRequest::where('user_id', Auth::id())
            ->where('type', self::TYPE)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function (ExportRequest $export) {
                return [
                    'id' => $export->id,
                    'file_name' => $export->file_name,
                    'status' => $export->status,
                    'error' => $export->error,
                    'created_at' => $export->created_at->format('d/m/Y H:i'),
                    'download_url' => $export->status === ExportRequest::DONE
                        ? route('opi.export.download', $export->id)
                        : null,
                ];
            });

        return response()->json($items);
    }

    public function download($id)
    {
        $export = ExportRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('type', self::TYPE)
            ->where('status', ExportRequest::DONE)
            ->firstOrFail();

        abort_unless(Storage::disk('local')->exists($export->file_path), 404, 'File export sudah tidak tersedia.');

        return Storage::disk('local')->download($export->file_path, $export->file_name);
    }
}
