<?php

namespace App\Http\Controllers;

use App\Models\CorrDetail;
use App\Models\CorrMaterialBooking;
use App\Models\CorrMaterialRequirement;
use App\Services\CorrMaterialBookingService;
use Illuminate\Http\Request;

class CorrMaterialBookingController extends Controller
{
    protected $service;

    public function __construct(CorrMaterialBookingService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index($detailId)
    {
        $detail = CorrDetail::with(['corrMaster', 'materialRequirements.bookings.inventory'])->findOrFail($detailId);
        return view('admin.plan.corr.material-booking', compact('detail'));
    }

    public function rolls(CorrMaterialRequirement $requirement)
    {
        return response()->json($this->service->getAvailableRolls($requirement)->map(function ($roll) {
            return [
                'id' => $roll->id,
                'kode_internal' => $roll->kode_internal,
                'kode_roll' => $roll->kode_roll,
                'tanggal_masuk' => $roll->tanggal_masuk ? date('d-m-Y', strtotime($roll->tanggal_masuk)) : null,
                'gsm' => $roll->gsm,
                'lebar' => $roll->lebar,
                'berat' => $roll->quantity,
                'available_qty' => $roll->available_qty,
            ];
        }));
    }

    public function autoSelect(CorrMaterialRequirement $requirement)
    {
        return response()->json(['selected' => $this->service->autoSelectRolls($requirement)]);
    }

    public function autoSelectAll(CorrDetail $detail)
    {
        return response()->json(['selected' => $this->service->autoSelectForDetail($detail)]);
    }

    public function book(Request $request, CorrMaterialRequirement $requirement)
    {
        $data = $request->validate([
            'selections' => 'required|array|min:1',
            'selections.*.inventory_id' => 'required|integer|exists:inventories,id',
            'selections.*.qty_booked' => 'required|numeric|gt:0',
        ]);

        try {
            $this->service->createBooking($requirement, $data['selections']);
            return redirect()->back()->with('success', 'Booking roll berhasil dikonfirmasi.');
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->withErrors(['booking' => $exception->getMessage()]);
        }
    }

    public function bookAll(Request $request, CorrDetail $detail)
    {
        $data = $request->validate([
            'selections' => 'required|array|min:1',
            'selections.*' => 'array|min:1',
            'selections.*.*.inventory_id' => 'required|integer|exists:inventories,id',
            'selections.*.*.qty_booked' => 'required|numeric|gt:0',
        ]);

        $requirementIds = $detail->materialRequirements()->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();

        if (array_diff(array_keys($data['selections']), $requirementIds)) {
            return redirect()->back()->withErrors(['booking' => 'Requirement booking tidak sesuai dengan planning ini.']);
        }

        try {
            $this->service->createBookings($data['selections']);
            return redirect()->back()->with('success', 'Seluruh booking roll berhasil dikonfirmasi.');
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->withErrors(['booking' => $exception->getMessage()]);
        }
    }

    public function release(CorrMaterialBooking $booking)
    {
        try {
            $this->service->releaseBooking($booking);
            return redirect()->back()->with('success', 'Booking berhasil di-release.');
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withErrors(['booking' => $exception->getMessage()]);
        }
    }
}
