<?php

namespace App\Console\Commands;

use App\Models\CorrDetail;
use App\Services\CorrMaterialBookingService;
use Illuminate\Console\Command;

class SyncCorrMaterialRequirements extends Command
{
    protected $signature = 'corr:sync-material-requirements';
    protected $description = 'Create or update material requirements from existing corr details';

    public function handle(CorrMaterialBookingService $service)
    {
        $count = 0;
        CorrDetail::query()->chunkById(100, function ($details) use ($service, &$count) {
            foreach ($details as $detail) {
                $service->syncRequirements($detail);
                $count++;
            }
        });

        $this->info("Synchronized {$count} corr details.");
        return self::SUCCESS;
    }
}
