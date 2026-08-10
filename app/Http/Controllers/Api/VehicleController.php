<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionLoad;
use App\Models\VehiclePhotos;

class VehicleController extends Controller
{
    public function get_vehicle_by_nopol($nopol)
    {
        $vehicle = TransactionLoad::where('vehicle_number', $nopol)
            ->where('date_out', null)
            ->first();

        if ($vehicle) {
            return response()->json([
                'success' => true,
                'data' => $vehicle,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found.',
            ]);
        }
    }

    public function get_vehicle_by_transaction($id)
    {
        $vehicle = VehiclePhotos::where("transaction_load_id", $id)->get();

        if ($vehicle) {
            return response()->json([
                'success' => true,
                'data' => $vehicle,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found.',
            ]);
        }
    }
}
