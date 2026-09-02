<?php

namespace App\Services;

use App\Models\CorrMaterialBooking;
use App\Models\CorrMaterialRequirement;
use App\Models\Inventory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CorrMaterialBookingService
{
    public function syncRequirements($detail)
    {
        $materials = [];
        for ($layer = 1; $layer <= 5; $layer++) {
            $jenis = trim((string) $detail->{"jenis_kertas{$layer}"});
            $qty = (float) $detail->{"kebutuhan_kertas{$layer}"};
            if ($jenis === '' || $qty <= 0) {
                continue;
            }

            $materials[$layer] = [
                'layer_no' => $layer,
                'jenis' => $jenis,
                'gsm' => (int) $detail->{"gram_kertas{$layer}"},
                'lebar_roll' => (int) $detail->lebar_roll,
                'qty_required' => $qty,
            ];
        }

        $existing = $detail->materialRequirements()->get()->keyBy('layer_no');
        foreach ($materials as $layer => $material) {
            $requirement = $existing->get($layer);
            if ($requirement) {
                $requirement->update($material);
                $this->updateRequirementStatus($requirement->fresh());
            } else {
                $requirement = $detail->materialRequirements()->create(array_merge($material, [
                    'qty_booked' => 0,
                    'status' => CorrMaterialRequirement::STATUS_PENDING,
                ]));
            }
        }

        $validLayers = array_keys($materials);
        $detail->materialRequirements()->get()->each(function ($requirement) use ($validLayers) {
            if (!in_array($requirement->layer_no, $validLayers, true) && $requirement->bookings()->exists()) {
                throw new InvalidArgumentException('Requirement ' . $requirement->jenis . ' memiliki riwayat booking dan tidak dapat dihapus.');
            }
            if (!in_array($requirement->layer_no, $validLayers, true)) {
                $requirement->delete();
            }
        });
    }

    public function availableStatusId()
    {
        return (int) config('app.inventory_available_status_id', 2);
    }

    public function calculateAvailableQty($inventory, $forUpdate = false)
    {
        $query = $inventory->materialBookings()->active();
        if ($forUpdate) {
            $query->lockForUpdate();
        }
        return max(0, (float) $inventory->quantity - (float) $query->sum('qty_booked'));
    }

    public function getAvailableRolls(CorrMaterialRequirement $requirement)
    {
        $inventories = Inventory::query()
            ->with('supplier')
            ->whereNull('deleted_at')
            ->where('jenis', $requirement->jenis)
            ->where('gsm', $requirement->gsm)
            ->where('lebar', $requirement->lebar_roll)
            ->where('status_roll_id', $this->availableStatusId())
            ->where('quantity', '>', 0)
            ->orderBy('tanggal_masuk')
            ->orderBy('id')
            ->get();

        return $inventories->map(function ($inventory) {
            $inventory->available_qty = $this->calculateAvailableQty($inventory);
            return $inventory;
        })->filter(function ($inventory) {
            return $inventory->available_qty > 0;
        })->values();
    }

    public function autoSelectRolls(CorrMaterialRequirement $requirement, $rolls = null)
    {
        $remaining = $requirement->remaining;
        $selected = [];
        foreach ($rolls ?: $this->getAvailableRolls($requirement) as $roll) {
            if ($remaining <= 0) {
                break;
            }
            $qty = min($remaining, (float) $roll->available_qty);
            if ($qty > 0) {
                $selected[] = ['inventory_id' => $roll->id, 'qty_booked' => $qty];
                $remaining -= $qty;
            }
        }
        return $selected;
    }

    public function autoSelectForDetail($detail)
    {
        $selectedRollIds = [];

        return $detail->materialRequirements()->orderBy('layer_no')->get()->mapWithKeys(function ($requirement) use (&$selectedRollIds) {
            $remaining = $requirement->remaining;
            $selected = [];

            foreach ($this->getAvailableRolls($requirement) as $roll) {
                if ($remaining <= 0) {
                    break;
                }

                if (isset($selectedRollIds[$roll->id])) {
                    continue;
                }

                $quantity = min($remaining, (float) $roll->available_qty);

                if ($quantity > 0) {
                    $selected[] = ['inventory_id' => $roll->id, 'qty_booked' => $quantity];
                    $selectedRollIds[$roll->id] = true;
                    $remaining -= $quantity;
                }
            }

            return [$requirement->id => $selected];
        });
    }

    public function createBookings(array $selectionsByRequirement)
    {
        return DB::transaction(function () use ($selectionsByRequirement) {
            $created = collect();

            foreach ($selectionsByRequirement as $requirementId => $selections) {
                if (!$selections) {
                    continue;
                }

                $requirement = CorrMaterialRequirement::findOrFail($requirementId);
                $created = $created->merge($this->createBooking($requirement, $selections));
            }

            return $created;
        });
    }

    public function createBooking(CorrMaterialRequirement $requirement, array $selections)
    {
        return DB::transaction(function () use ($requirement, $selections) {
            $lockedRequirement = CorrMaterialRequirement::whereKey($requirement->id)->lockForUpdate()->firstOrFail();
            $remaining = $lockedRequirement->remaining;
            if ($remaining <= 0) {
                throw new InvalidArgumentException('Requirement sudah terpenuhi.');
            }
            if (!$selections) {
                throw new InvalidArgumentException('Pilih minimal satu roll.');
            }

            $created = collect();
            foreach ($selections as $selection) {
                $qty = (float) ($selection['qty_booked'] ?? 0);
                if ($qty <= 0) {
                    throw new InvalidArgumentException('Quantity booking harus lebih besar dari 0.');
                }
                $inventory = Inventory::whereKey($selection['inventory_id'])
                    ->whereNull('deleted_at')->lockForUpdate()->first();
                if (!$inventory || $inventory->jenis !== $lockedRequirement->jenis ||
                    (int) $inventory->gsm !== (int) $lockedRequirement->gsm ||
                    (int) $inventory->lebar !== (int) $lockedRequirement->lebar_roll ||
                    (int) $inventory->status_roll_id !== $this->availableStatusId()) {
                    throw new InvalidArgumentException('Roll tidak sesuai dengan requirement.');
                }
                $available = $this->calculateAvailableQty($inventory, true);
                if ($qty > $available) {
                    throw new InvalidArgumentException("Roll {$inventory->kode_roll} hanya tersedia {$available}.");
                }
                if ($qty > $remaining) {
                    throw new InvalidArgumentException('Total booking melebihi sisa requirement.');
                }
                $created->push(CorrMaterialBooking::create([
                    'corr_material_requirement_id' => $lockedRequirement->id,
                    'inventory_id' => $inventory->id,
                    'qty_booked' => $qty,
                    'status' => CorrMaterialBooking::STATUS_BOOKED,
                    'booked_at' => Carbon::now(),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]));
                $remaining -= $qty;
            }
            $this->updateRequirementStatus($lockedRequirement);
            return $created;
        });
    }

    public function releaseBooking(CorrMaterialBooking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $booking = CorrMaterialBooking::whereKey($booking->id)->lockForUpdate()->firstOrFail();
            if ($booking->status !== CorrMaterialBooking::STATUS_BOOKED) {
                throw new InvalidArgumentException('Booking ini tidak dapat di-release.');
            }
            $booking->update(['status' => CorrMaterialBooking::STATUS_RELEASED, 'released_at' => Carbon::now(), 'updated_by' => auth()->id()]);
            $this->updateRequirementStatus($booking->requirement()->lockForUpdate()->first());
            return $booking;
        });
    }

    public function updateRequirementStatus(CorrMaterialRequirement $requirement)
    {
        $booked = $requirement->bookings()->active()->sum('qty_booked');
        $status = $booked <= 0 ? CorrMaterialRequirement::STATUS_PENDING :
            ($booked >= $requirement->qty_required ? CorrMaterialRequirement::STATUS_FULLY_BOOKED : CorrMaterialRequirement::STATUS_PARTIAL);
        $requirement->update(['qty_booked' => $booked, 'status' => $status]);
        return $requirement;
    }
}
