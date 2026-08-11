<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\TransactionLoad;
use App\Models\VehiclePhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $vehicle = $query->orderByRaw("CASE WHEN status = 'finish' THEN 2 ELSE 1 END")
            ->orderBy('date_in', 'asc')
            ->paginate(10);

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
            'status' => 'required|in:load,unload',
        ]);

        DB::beginTransaction();
        try {
            $transactionLoad = new TransactionLoad();
            $transactionLoad->driver_name = $request->input('driver_name');
            $transactionLoad->vehicle_number = $request->input('vehicle_number');
            $transactionLoad->masterdata_id = $request->input('masterdata_id') ?? null;
            $transactionLoad->destination = $request->input('destination') ?? null;
            $transactionLoad->type = $request->input('type') ?? null;
            $transactionLoad->status = $request->input('status');
            $transactionLoad->date_in = now();
            $transactionLoad->save();

            foreach ($request->file('images', []) as $file) {
                if ($file != null) {
                    $nama_file = time()."_".$file->getClientOriginalName();

                    $tujuan_upload = 'upload_vehicle';
                    $file->move($tujuan_upload, $nama_file);
                } else {
                    $nama_file = '';
                }

                VehiclePhotos::create([
                    'transaction_load_id' => $transactionLoad->id,
                    'photo_path' => $nama_file,
                    'photo_type' => 'in',
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('vehicle.index')->with('error', 'Failed to create vehicle transaction.');
        }

            DB::commit();
            return redirect()->route('vehicle.index')->with('success', 'Vehicle transaction created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:255',
            'masterdata_id' => 'required|exists:masterdatas,id',
            'destination' => 'required|string|max:255',
            'type' => 'required|in:customer,supplier',
            'status' => 'required|in:load,unload',
        ]);

        DB::beginTransaction();
        try {
            $transactionLoad = TransactionLoad::findOrFail($id);
            $transactionLoad->driver_name = $request->input('driver_name');
            $transactionLoad->vehicle_number = $request->input('vehicle_number');
            $transactionLoad->masterdata_id = $request->input('masterdata_id');
            $transactionLoad->destination = $request->input('destination');
            $transactionLoad->type = $request->input('type');
            $transactionLoad->status = 'finish'; // Set status to 'finish' when updating
            $transactionLoad->date_out = now();
            $transactionLoad->save();

            foreach ($request->file('images', []) as $photo) {
                if ($photo != null) {
                    $nama_file = time()."_".$photo->getClientOriginalName();
                    $photo->move('upload_vehicle', $nama_file);
                } else {
                    $nama_file = '';
                }

                VehiclePhotos::create([
                    'transaction_load_id' => $transactionLoad->id,
                    'photo_path' => $nama_file,
                    'photo_type' => 'out',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('vehicle.index')->with('error', 'Failed to update vehicle transaction.');
        }

        DB::commit();
        return redirect()->route('vehicle.index')->with('success', 'Vehicle transaction updated successfully.');
    }

    public function show($id)
    {
        $vehicle = VehiclePhotos::with('transactionLoad')->findOrFail($id);

        return view('admin.vehicle.show', compact('vehicle'));
    }


}
