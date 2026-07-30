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
}
