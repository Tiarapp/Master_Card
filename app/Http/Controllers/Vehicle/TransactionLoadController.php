<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\TransactionLoad;
use Illuminate\Http\Request;

class TransactionLoadController extends Controller
{
    public function index(Request $request)
    {
        $query = new TransactionLoad();
        $search = $request->input('search');

        $query = $query->with('masterdata');

        if ($search) {
            $query = $query->where('driver_name', 'like', "%$search%")
                ->orWhere('vehicle_number', 'like', "%$search%")
                ->orWhereHas('masterdata', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        }

        $vehicle = $query->orderBy('date_in', 'desc')->paginate(10);

        $data = [
            'vehicle' => $vehicle,
            'search' => $search,
        ];

        return view('admin.vehicle.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:255',
            'masterdata_id' => 'required|exists:masterdata,id',
            'destination' => 'required|string|max:255',
            'date_in' => 'required|date',
        ]);

        TransactionLoad::create($request->all());

        return redirect()->route('vehicle.index')->with('success', 'Vehicle transaction created successfully.');
    }

    public function show($id)
    {
        $vehicle = TransactionLoad::with('masterdata')->findOrFail($id);

        return view('admin.vehicle.show', compact('vehicle'));
    }
}
