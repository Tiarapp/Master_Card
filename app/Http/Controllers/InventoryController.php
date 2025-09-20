<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Potongan;
use App\Models\SupplierRoll;
use App\Imports\InventoryUpdateWithRgbImport;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventories = new Inventory();
        $inventories = $inventories->with(['supplier', 'potongan']);

        // Apply search filter
        if ($request->search) {
            $inventories = $inventories->where('kode_internal', 'like', '%'.$request->search.'%')
                ->orWhere('kode_roll', 'like', '%'.$request->search.'%')
                ->orWhere('gsm', 'like', '%'.$request->search.'%')
                ->orWhere('jenis', 'like', '%'.$request->search.'%')
                ->orWhere('lebar', 'like', '%'.$request->search.'%')
                ->orWhere('descoription', 'like', '%'.$request->search.'%')
                ->orWhereHas('supplier', function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search.'%');
                });
        }

        // Apply GSM filter
        if ($request->gsm_filter && $request->gsm_filter != '') {
            $inventories = $inventories->where('gsm', $request->gsm_filter);
        }

        // Apply Lebar filter
        if ($request->lebar_filter && $request->lebar_filter != '') {
            $inventories = $inventories->where('lebar', $request->lebar_filter);
        }

        // Apply Supplier filter
        if ($request->supplier_filter && $request->supplier_filter != '') {
            $inventories = $inventories->where('supplier_id', $request->supplier_filter);
        }

        // Apply Jenis filter
        if ($request->jenis_filter && $request->jenis_filter != '') {
            $inventories = $inventories->where('jenis', $request->jenis_filter);
        }

        $inventories = $inventories->orderBy('tanggal_masuk', 'desc')
                       ->orderBy('kode_internal', 'desc')
                       ->paginate(20);
        
        // Get data for filters
        $supplier = SupplierRoll::orderBy('name')->get();
        $gsmOptions = Inventory::select('gsm')->distinct()->whereNotNull('gsm')->orderBy('gsm')->pluck('gsm');
        $lebarOptions = Inventory::select('lebar')->distinct()->whereNotNull('lebar')->orderBy('lebar')->pluck('lebar');
        $jenisOptions = Inventory::select('jenis')->distinct()->whereNotNull('jenis')->orderBy('jenis')->pluck('jenis');

        $data = [
            'inventories' => $inventories,
            'supplier' => $supplier,
            'gsmOptions' => $gsmOptions,
            'lebarOptions' => $lebarOptions,
            'jenisOptions' => $jenisOptions
        ];

        return view('admin.inventory.index', $data);
    }

    public function create()
    {
        // Get data for dropdowns
        $supplier = SupplierRoll::orderBy('name')->get();

        $data = [
            'supplier' => $supplier
        ];

        return view('admin.inventory.create', $data);
    }

    public function store(Request $request)
    {
        // Validate header data
        $request->validate([
            'supplier_id' => 'required|exists:supplier_rolls,id',
            'tanggal_masuk' => 'required|date',
            'jumlah_roll' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Create inventory items
            foreach ($request->inventories as $inventoryData) {
                $inventory = new Inventory();
                $inventory->kode_internal = $inventoryData['kode_internal'];
                $inventory->kode_roll = $inventoryData['kode_roll'];
                $inventory->gsm = $inventoryData['gsm'];
                $inventory->jenis = $inventoryData['jenis'];
                $inventory->lebar = $inventoryData['lebar'];
                $inventory->supplier_id = $request->supplier_id;
                $inventory->kw = $inventoryData['jenis_kw'];
                $inventory->quantity = $inventoryData['berat_timbang'];
                $inventory->berat_timbang = $inventoryData['berat_timbang'];
                $inventory->berat_sj = $inventoryData['berat_sj'];
                $inventory->tanggal_masuk = $request->tanggal_masuk;
                $inventory->status_roll_id = 1;
                $inventory->purchase_order = $inventoryData['purchase_order'] ?? null;
                $inventory->save();
            }

            // Update supplier sequence
            $supplier = SupplierRoll::find($request->supplier_id);
            $supplier->number_seq = $supplier->number_seq + $request->jumlah_roll;
            $supplier->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data inventory: ' . $e->getMessage()])->withInput();
        }

        return redirect(route('inventory.index'))->with('success', 'Inventory berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        // Update only the description field
        $inventory->descoription = $request->description;
        $inventory->save();

        return response()->json([
            'success' => true,
            'message' => 'Keterangan berhasil disimpan!'
        ]);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory berhasil dihapus!');
    }

    public function showImportUpdate()
    {
        return view('admin.inventory.import-update');
    }

    public function showImportInventory()
    {
        return view('admin.inventory.import-inventory');
    }

    public function importInventory(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ], [
            'file.required' => 'File import wajib dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            // Use custom import class for full inventory import
            $import = new InventoryImport();
            
            // Get temporary file path
            $filePath = $request->file('file')->getPathname();
            
            // Process import
            $import->import($filePath);

            $message = "Import inventory berhasil! ";
            $message .= "Data diimport: {$import->getImportedCount()}, ";
            $message .= "Dilewati (sudah ada): {$import->getSkippedCount()}";

            if (!empty($import->getErrors())) {
                $errorMessages = implode('; ', array_slice($import->getErrors(), 0, 5));
                if (count($import->getErrors()) > 5) {
                    $errorMessages .= '... dan ' . (count($import->getErrors()) - 5) . ' error lainnya';
                }
                $message .= ". Errors: " . $errorMessages;
            }

            return redirect()->route('inventory.import.inventory.form')
                ->with('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = "Validasi gagal pada baris: ";
            
            foreach ($failures as $failure) {
                $errorMessage .= "Baris {$failure->row()}: " . implode(', ', $failure->errors()) . "; ";
            }

            return redirect()->route('inventory.import.inventory.form')
                ->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->route('inventory.import.inventory.form')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function importUpdateWithRgb(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ], [
            'file.required' => 'File import wajib dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            // Use custom import class that saves RGB codes directly
            $import = new InventoryUpdateWithRgbImport();
            
            // Get temporary file path
            $filePath = $request->file('file')->getPathname();
            
            // Process import
            $import->import($filePath);

            $message = "Import RGB berhasil! ";
            $message .= "Data diupdate: {$import->getUpdatedCount()}, ";
            $message .= "Tidak ditemukan: {$import->getNotFoundCount()}";

            if (!empty($import->getErrors())) {
                $errorMessages = implode('; ', array_slice($import->getErrors(), 0, 5));
                if (count($import->getErrors()) > 5) {
                    $errorMessages .= '... dan ' . (count($import->getErrors()) - 5) . ' error lainnya';
                }
                $message .= ". Errors: " . $errorMessages;
            }

            return redirect()->route('inventory.import.update.form')
                ->with('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = "Validasi gagal pada baris: ";
            
            foreach ($failures as $failure) {
                $errorMessage .= "Baris {$failure->row()}: " . implode(', ', $failure->errors()) . "; ";
            }

            return redirect()->route('inventory.import.update.form')
                ->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->route('inventory.import.update.form')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="template_update_inventory.xlsx"',
        ];

        // Sample data untuk template - menggunakan data inventory yang ada
        $sampleInventories = Inventory::limit(3)->get(['kode_internal']);
        $sampleData = [];
        
        foreach ($sampleInventories as $index => $inventory) {
            $sampleData[] = [
                'kode_internal' => $inventory->kode_internal,
                'warna' => $index == 0 ? 'SAMA' : ($index == 1 ? 'BEDA' : 'SAMA'),
                'gsm_act' => 125.5 + ($index * 5),
                'cobsize_top' => 10.5 + ($index * 0.7),
                'cobsize_back' => 8.2 + ($index * 0.9),
                'rct_cd' => number_format(150 + ($index * 10), 2, '.', ''),
                'rct_md' => number_format(180 + ($index * 10), 2, '.', '')
            ];
        }
        
        // Jika tidak ada inventory, gunakan contoh default
        if (empty($sampleData)) {
            $sampleData = [
                [
                    'kode_internal' => 'CONTOH001',
                    'warna' => 'SAMA',
                    'gsm_act' => '125.50',
                    'cobsize_top' => '10.50',
                    'cobsize_back' => '8.20',
                    'rct_cd' => '150.00',
                    'rct_md' => '180.00'
                ]
            ];
        }

        return Excel::download(new class($sampleData) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
            
            public function __construct($data) {
                $this->data = collect($data);
            }
            
            public function collection() {
                return $this->data;
            }
            
            public function headings(): array {
                return [
                    'kode_internal',
                    'warna',
                    'gsm_act',
                    'cobsize_top',
                    'cobsize_back',
                    'rct_cd',
                    'rct_md'
                ];
            }
        }, 'template_update_inventory.xlsx', \Maatwebsite\Excel\Excel::XLSX, $headers);
    }

    public function downloadInventoryTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="template_import_inventory.xlsx"',
        ];

        // Sample data untuk template inventory lengkap
        $suppliers = SupplierRoll::limit(3)->get(['id', 'name']);
        $sampleData = [];
        
        foreach ($suppliers as $index => $supplier) {
            $sampleData[] = [
                'tanggal_masuk' => date('Y-m-d'),
                'kode_internal' => 'INV' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'kw' => $index == 0 ? 'KW1' : ($index == 1 ? 'KW2' : 'KW3'),
                'jenis' => $index == 0 ? 'COATED' : ($index == 1 ? 'UNCOATED' : 'NEWSPRINT'),
                'gsm' => 80 + ($index * 10),
                'kode_roll' => 'R' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'lebar' => 120 + ($index * 5),
                'berat_sj' => 1000 + ($index * 100),
                'berat_timbang' => 995 + ($index * 100),
                'quantity' => 995 + ($index * 100),
                'supplier_id' => $supplier->id,
                'purchase_order' => 'PO' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'description' => 'Roll kertas ' . ($index + 1)
            ];
        }
        
        // Jika tidak ada supplier, gunakan contoh default
        if (empty($sampleData)) {
            $sampleData = [
                [
                    'tanggal_masuk' => date('Y-m-d'),
                    'kode_internal' => 'INV000001',
                    'kw' => 'KW1',
                    'jenis' => 'COATED',
                    'gsm' => 80,
                    'kode_roll' => 'R0001',
                    'lebar' => 120,
                    'berat_sj' => 1000,
                    'berat_timbang' => 995,
                    'quantity' => 995,
                    'supplier_id' => 1,
                    'purchase_order' => 'PO000001',
                    'description' => 'Roll kertas contoh'
                ]
            ];
        }

        return Excel::download(new class($sampleData) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
            
            public function __construct($data) {
                $this->data = collect($data);
            }
            
            public function collection() {
                return $this->data;
            }
            
            public function headings(): array {
                return [
                    'tanggal_masuk',
                    'kode_internal',
                    'kw',
                    'jenis',
                    'gsm',
                    'kode_roll',
                    'lebar',
                    'berat_sj',
                    'berat_timbang',
                    'quantity',
                    'supplier_id',
                    'purchase_order',
                    'description'
                ];
            }
        }, 'template_import_inventory.xlsx', \Maatwebsite\Excel\Excel::XLSX, $headers);
    }

    public function summary(Request $request)
    {
        // Group by jenis, gsm, and lebar with quantity sum
        $summaryQuery = Inventory::select(
            'jenis',
            'gsm', 
            'lebar',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('COUNT(*) as total_rolls'),
            DB::raw('AVG(berat_timbang) as avg_weight')
        )
        ->whereNotNull('jenis')
        ->whereNotNull('gsm')
        ->whereNotNull('lebar')
        ->where('quantity', '>', 0); // Only show items with quantity > 0

        // Apply filters if provided
        if ($request->jenis_filter) {
            $summaryQuery->where('jenis', $request->jenis_filter);
        }
        
        if ($request->gsm_filter) {
            $summaryQuery->where('gsm', $request->gsm_filter);
        }
        
        if ($request->lebar_filter) {
            $summaryQuery->where('lebar', $request->lebar_filter);
        }

        if ($request->supplier_filter) {
            $summaryQuery->where('supplier_id', $request->supplier_filter);
        }

        $summaryData = $summaryQuery
            ->groupBy('jenis', 'gsm', 'lebar')
            ->orderBy('jenis')
            ->orderBy('gsm')
            ->orderBy('lebar')
            ->paginate(20);

        // Get filter options
        $jenisOptions = Inventory::select('jenis')->distinct()->whereNotNull('jenis')->orderBy('jenis')->pluck('jenis');
        $gsmOptions = Inventory::select('gsm')->distinct()->whereNotNull('gsm')->orderBy('gsm')->pluck('gsm');
        $lebarOptions = Inventory::select('lebar')->distinct()->whereNotNull('lebar')->orderBy('lebar')->pluck('lebar');
        $supplierOptions = SupplierRoll::orderBy('name')->get();

        // Calculate totals from all data (not just current page)
        $allSummaryData = $summaryQuery
            ->groupBy('jenis', 'gsm', 'lebar')
            ->get();
        $grandTotal = $allSummaryData->sum('total_quantity');
        $totalVariants = $allSummaryData->count();
        $totalRolls = $allSummaryData->sum('total_rolls');
        $avgWeight = $allSummaryData->avg('avg_weight');

        $data = [
            'summaryData' => $summaryData,
            'jenisOptions' => $jenisOptions,
            'gsmOptions' => $gsmOptions,
            'lebarOptions' => $lebarOptions,
            'supplierOptions' => $supplierOptions,
            'grandTotal' => $grandTotal,
            'totalVariants' => $totalVariants,
            'totalRolls' => $totalRolls,
            'avgWeight' => $avgWeight,
            'filters' => $request->all()
        ];

        return view('admin.inventory.summary', $data);
    }

    /**
     * Get available inventories for BBK Roll (API)
     */
    public function getAvailableInventories(Request $request)
    {
        $inventories = Inventory::with(['supplier', 'potongan'])
            ->select('id', 'kode_internal', 'kode_roll', 'supplier_id', 'gsm', 'lebar', 'quantity', 'potongan_id');

        // Exclude already used inventories
        if ($request->exclude && is_array($request->exclude)) {
            $inventories->whereNotIn('id', $request->exclude);
        }

        // Apply search filter
        if ($request->search) {
            $search = $request->search;
            $inventories->where(function($query) use ($search) {
                $query->where('kode_internal', 'like', '%'.$search.'%')
                    ->orWhere('kode_roll', 'like', '%'.$search.'%')
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        $inventories = $inventories->orderBy('kode_internal')
            ->limit(50)
            ->get();

        return response()->json($inventories);
    }

    /**
     * Get inventory details (API)
     */
    public function getInventoryDetails($id)
    {
        $inventory = Inventory::with('supplier')
            ->findOrFail($id);

        return response()->json($inventory);
    }

    /**
     * Get paginated inventory for BBK Roll creation
     */
    public function getPaginatedInventory(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search', '');
        $supplier = $request->get('supplier', '');

        $inventoriesQuery = Inventory::with(['supplier'])
            ->where('quantity', '>', 0); // Only show inventory with quantity > 0

        // Apply search filter
        if ($search) {
            $inventoriesQuery->where(function($query) use ($search) {
                $query->where('kode_internal', 'like', '%'.$search.'%')
                    ->orWhere('kode_roll', 'like', '%'.$search.'%')
                    ->orWhere('gsm', 'like', '%'.$search.'%')
                    ->orWhere('jenis', 'like', '%'.$search.'%')
                    ->orWhere('lebar', 'like', '%'.$search.'%')
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        // Apply supplier filter
        if ($supplier) {
            $inventoriesQuery->whereHas('supplier', function ($q) use ($supplier) {
                $q->where('name', $supplier);
            });
        }

        $inventories = $inventoriesQuery->orderBy('kode_internal')
            ->paginate($perPage);

        // Transform data for frontend
        $transformedData = $inventories->map(function($inventory) {
            return [
                'id' => $inventory->id,
                'kode_internal' => $inventory->kode_internal,
                'kode_roll' => $inventory->kode_roll,
                'supplier_name' => $inventory->supplier->name ?? null,
                'jenis' => $inventory->jenis,
                'gsm' => $inventory->gsm,
                'lebar' => $inventory->lebar,
                'quantity' => $inventory->quantity
            ];
        });

        // Get unique suppliers for filter dropdown
        $suppliers = [];
        if (!$search && !$supplier) {
            $suppliers = Inventory::with('supplier')
                ->whereHas('supplier')
                ->where('quantity', '>', 0)
                ->get()
                ->pluck('supplier.name')
                ->unique()
                ->filter()
                ->map(function($name) {
                    return ['name' => $name];
                })
                ->values()
                ->toArray();
        }

        return response()->json([
            'success' => true,
            'data' => $transformedData,
            'pagination' => [
                'current_page' => $inventories->currentPage(),
                'last_page' => $inventories->lastPage(),
                'per_page' => $inventories->perPage(),
                'total' => $inventories->total(),
                'from' => $inventories->firstItem(),
                'to' => $inventories->lastItem()
            ],
            'suppliers' => $suppliers
        ]);
    }
}
