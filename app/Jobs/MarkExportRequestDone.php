<?php

namespace App\Jobs;

use App\Models\ExportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarkExportRequestDone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $exportRequestId;

    public function __construct(int $exportRequestId)
    {
        $this->exportRequestId = $exportRequestId;
    }

    public function handle()
    {
        ExportRequest::whereKey($this->exportRequestId)
            ->where('status', '!=', ExportRequest::FAILED)
            ->update(['status' => ExportRequest::DONE, 'updated_at' => now()]);
    }
}
