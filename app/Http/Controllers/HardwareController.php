<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Imports\HardwareImport;
use App\Exports\HardwareExport;
use App\Exports\HardwareTemplateExport;
use App\Exports\HardwareTemplateSimpleExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class HardwareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['downloadTemplate']);
        // Sementara disable middleware divisi_id untuk testing
        /*
        $this->middleware(function ($request, $next) {
            if (Auth::user()->divisi_id != 2) {
                abort(403, 'Akses ditolak. Hanya divisi IT yang dapat mengakses halaman ini.');
            }
            return $next($request);
        });
        */
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hardware::query();

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan divisi
        if ($request->filled('divisi')) {
            $query->where('divisi', 'LIKE', '%' . $request->divisi . '%');
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_hardware', 'LIKE', '%' . $search . '%')
                  ->orWhere('nama_hardware', 'LIKE', '%' . $search . '%')
                  ->orWhere('merk', 'LIKE', '%' . $search . '%')
                  ->orWhere('model', 'LIKE', '%' . $search . '%')
                  ->orWhere('serial_number', 'LIKE', '%' . $search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $search . '%')
                  ->orWhere('pic_pengguna', 'LIKE', '%' . $search . '%');
            });
        }

        // Sorting
        $query->orderBy('created_at', 'desc');

        // Pagination
        $perPage = $request->get('per_page', 10);
        $hardwares = $query->paginate($perPage);

        $kategoris = ['Komputer', 'Laptop', 'Server', 'Network', 'Printer', 'Scanner', 'Proyektor', 'Monitor', 'Storage', 'Others'];
        $statuses = ['Aktif', 'Maintenance', 'Rusak', 'Retired'];
        
        return view('admin.hardware.index', compact('hardwares', 'kategoris', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = ['Komputer', 'Laptop', 'Server', 'Network', 'Printer', 'Scanner', 'Proyektor', 'Monitor', 'Storage', 'Others'];
        $statuses = ['Aktif', 'Maintenance', 'Rusak', 'Retired'];
        
        return view('admin.hardware.create', compact('kategoris', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Hardware store request data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'kode_hardware' => 'required|unique:hardware,kode_hardware|max:50',
            'nama_hardware' => 'required|max:255',
            'kategori' => 'required|in:Komputer,Laptop,Server,Network,Printer,Scanner,Proyektor,Monitor,Storage,Others',
            'status' => 'required|in:Aktif,Maintenance,Rusak,Retired',
            'tanggal_pembelian' => 'nullable|date',
            'harga_pembelian' => 'nullable|numeric|min:0',
            'tanggal_garansi_mulai' => 'nullable|date',
            'tanggal_garansi_selesai' => 'nullable|date|after_or_equal:tanggal_garansi_mulai',
        ]);

        if ($validator->fails()) {
            Log::error('Hardware validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->name ?? 'System';

            $hardware = Hardware::create($data);
            Log::info('Hardware created successfully:', $hardware->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Hardware berhasil ditambahkan!',
                'data' => $hardware
            ]);
        } catch (\Exception $e) {
            Log::error('Hardware creation failed:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hardware = Hardware::findOrFail($id);
        return response()->json($hardware);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hardware = Hardware::findOrFail($id);
        
        // Format dates for HTML date inputs (YYYY-MM-DD)
        $hardwareArray = $hardware->toArray();
        
        if ($hardwareArray['tanggal_pembelian']) {
            $hardwareArray['tanggal_pembelian'] = date('Y-m-d', strtotime($hardwareArray['tanggal_pembelian']));
        }
        
        if ($hardwareArray['tanggal_garansi_mulai']) {
            $hardwareArray['tanggal_garansi_mulai'] = date('Y-m-d', strtotime($hardwareArray['tanggal_garansi_mulai']));
        }
        
        if ($hardwareArray['tanggal_garansi_selesai']) {
            $hardwareArray['tanggal_garansi_selesai'] = date('Y-m-d', strtotime($hardwareArray['tanggal_garansi_selesai']));
        }
        
        return response()->json(['hardware' => $hardwareArray]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hardware = Hardware::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_hardware' => 'required|max:50|unique:hardware,kode_hardware,'.$id,
            'nama_hardware' => 'required|max:255',
            'kategori' => 'required|in:Komputer,Laptop,Server,Network,Printer,Scanner,Proyektor,Monitor,Storage,Others',
            'status' => 'required|in:Aktif,Maintenance,Rusak,Retired',
            'tanggal_pembelian' => 'nullable|date',
            'harga_pembelian' => 'nullable|numeric|min:0',
            'tanggal_garansi_mulai' => 'nullable|date',
            'tanggal_garansi_selesai' => 'nullable|date|after_or_equal:tanggal_garansi_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['updated_by'] = Auth::user()->name;

        $hardware->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Hardware berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $hardware = Hardware::findOrFail($id);
            $hardware->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hardware berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus hardware!'
            ], 500);
        }
    }

    /**
     * Import hardware from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Log::info('Starting hardware import', ['file' => $request->file('file')->getClientOriginalName()]);
            
            Excel::import(new HardwareImport, $request->file('file'));

            Log::info('Hardware import completed successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'Data hardware berhasil diimport!'
            ]);
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            Log::error('Hardware import validation failed', ['errors' => $errors]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal:',
                'errors' => $errors
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Hardware import error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export hardware to Excel
     */
    public function export()
    {
        try {
            Log::info('Starting hardware export via Artisan command');
            
            // Run Artisan command to generate export file
            $filename = 'hardware_export_' . date('Y-m-d') . '.csv';
            $filePath = public_path($filename);
            
            // Execute Artisan command to create export file
            Artisan::call('hardware:export');
            
            // Check if file exists
            if (!file_exists($filePath)) {
                throw new \Exception('Export file could not be created');
            }
            
            Log::info('Hardware export file created successfully via command', ['file' => $filename]);
            
            // Download the file
            return response()->download($filePath, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ])->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            Log::error('Hardware export error: ' . $e->getMessage());
            return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get template for import
     */
    public function downloadTemplate()
    {
        $filePath = public_path('template_import_hardware.csv');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'template_import_hardware_' . date('Y-m-d') . '.csv', [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }
        
        return response()->json(['error' => 'Template file not found'], 404);
    }
}
