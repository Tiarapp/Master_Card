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

        $vehicle = $query->orderByRaw("CASE WHEN status_load = 'Selesai' THEN 2 ELSE 1 END")
            ->orderByRaw("CASE WHEN status_load = 'Selesai' THEN date_in END DESC")
            ->orderByRaw("CASE WHEN status_load != 'Selesai' THEN date_in END ASC")
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
            'status' => 'required',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
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
            $transactionLoad->status_load = 'Proses';
            $transactionLoad->date_in = now();
            $transactionLoad->save();

            foreach ($request->file('images', []) as $file) {
                if ($file != null) {
                    $nama_file = $this->compressImage($file);
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
            // 'status' => 'required|in:load,unload',
        ]);

        DB::beginTransaction();
        try {
            $transactionLoad = TransactionLoad::findOrFail($id);
            $transactionLoad->driver_name = $request->input('driver_name');
            $transactionLoad->vehicle_number = $request->input('vehicle_number');
            $transactionLoad->masterdata_id = $request->input('masterdata_id');
            $transactionLoad->destination = $request->input('destination');
            $transactionLoad->type = $request->input('type');
            $transactionLoad->status_load = 'Selesai';
            $transactionLoad->date_out = now();
            $transactionLoad->save();

            foreach ($request->file('images', []) as $photo) {
                if ($photo != null) {
                    $nama_file = $this->compressImage($photo);
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

    private function compressImage($file)
    {
        if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
            throw new \RuntimeException('PHP GD with WebP support is required to process vehicle images.');
        }

        $image = imagecreatefromstring(file_get_contents($file->getRealPath()));

        if ($image === false) {
            throw new \RuntimeException('The uploaded image could not be read.');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $maxWidth = 1200;
        $targetWidth = min($width, $maxWidth);
        $targetHeight = (int) round($height * ($targetWidth / $width));
        $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        imagecopyresampled(
            $resizedImage,
            $image,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $width,
            $height
        );

        $namaFile = uniqid() . '.webp';
        $path = public_path('upload_vehicle/' . $namaFile);
        $saved = imagewebp($resizedImage, $path, 80);

        imagedestroy($resizedImage);
        imagedestroy($image);

        if (!$saved) {
            throw new \RuntimeException('The compressed image could not be saved.');
        }

        return $namaFile;
    }


}
