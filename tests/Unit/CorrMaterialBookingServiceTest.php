<?php

namespace Tests\Unit;

use App\Models\CorrMaterialBooking;
use App\Models\CorrMaterialRequirement;
use App\Services\CorrMaterialBookingService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CorrMaterialBookingServiceTest extends TestCase
{
    public function test_auto_select_uses_fifo_and_allows_partial_last_roll()
    {
        $requirement = new CorrMaterialRequirement([
            'qty_required' => 1200,
            'qty_booked' => 0,
        ]);
        $rolls = new Collection([
            (object) ['id' => 101, 'available_qty' => 700],
            (object) ['id' => 102, 'available_qty' => 650],
            (object) ['id' => 103, 'available_qty' => 800],
        ]);

        $selected = (new CorrMaterialBookingService)->autoSelectRolls($requirement, $rolls);

        $this->assertSame([
            ['inventory_id' => 101, 'qty_booked' => 700.0],
            ['inventory_id' => 102, 'qty_booked' => 500.0],
        ], $selected);
    }

    public function test_booking_statuses_exclude_released_bookings()
    {
        $this->assertSame('BOOKED', CorrMaterialBooking::STATUS_BOOKED);
        $this->assertNotSame(CorrMaterialBooking::STATUS_BOOKED, CorrMaterialBooking::STATUS_RELEASED);
        $this->assertNotSame(CorrMaterialBooking::STATUS_BOOKED, CorrMaterialBooking::STATUS_ISSUED);
        $this->assertNotSame(CorrMaterialBooking::STATUS_BOOKED, CorrMaterialBooking::STATUS_CANCELLED);
    }
}
