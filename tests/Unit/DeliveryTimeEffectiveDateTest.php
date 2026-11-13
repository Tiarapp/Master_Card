<?php

namespace Tests\Unit;

use App\Exports\PlanKirimExport;
use App\Models\DeliveryTime;
use PHPUnit\Framework\TestCase;

class DeliveryTimeEffectiveDateTest extends TestCase
{
    public function test_effective_date_depends_only_on_ppic_approval(): void
    {
        $this->assertSame('2026-02-01', DeliveryTime::effectiveDate('2026-01-01', '2026-02-01', 1));
        $this->assertSame('2026-01-01', DeliveryTime::effectiveDate('2026-01-01', '2026-02-01', 0));
        $this->assertSame('2026-01-01', DeliveryTime::effectiveDate('2026-01-01', null, 1));
        $this->assertSame('2026-01-01', DeliveryTime::effectiveDate('2026-01-01', '', 1));
    }

    public function test_plan_export_uses_related_dt_and_requires_only_ppic_approval(): void
    {
        $item = (object) [
            'NoOPI' => 'OPI-1',
            'tglKirimDt' => '2026-01-01',
            'jumlahOrder' => 100,
            'mc' => (object) [],
            'kontrakm' => (object) ['tglKontrak' => null],
            'dt' => (object) [
                'tglKirimDt' => '2026-01-01',
                'dt_perubahan' => '2026-02-01',
                'approve_mkt' => 0,
                'approve_ppic' => 1,
            ],
        ];
        $export = new PlanKirimExport(collect([$item]), '2026-01-01');
        $this->assertSame('01/02/2026 (Perubahan)', $export->collection()->first()['tanggal_kirim']);

        $item->dt->approve_ppic = 0;
        $this->assertSame('01/01/2026', $export->collection()->first()['tanggal_kirim']);
        $item->dt->approve_ppic = 1;
        $item->dt->dt_perubahan = null;
        $this->assertSame('01/01/2026', $export->collection()->first()['tanggal_kirim']);
    }
}
