<?php

namespace App\Http\Controllers;

use App\Models\BbkRoll;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BbkRollController extends Controller
{
    public function index(Request $request)
    {
        $bbkRollsQuery = BbkRoll::with(['inventory.supplier']);

        // Apply search filter
        if ($request->search) {
            $bbkRollsQuery = $bbkRollsQuery->where('bbk_number', 'like', '%'.$request->search.'%')
                ->orWhere('opi', 'like', '%'.$request->search.'%')
                ->orWhere('keterangan', 'like', '%'.$request->search.'%')
                ->orWhereHas('inventory', function ($query) use ($request) {
                    $query->where('kode_internal', 'like', '%'.$request->search.'%')
                        ->orWhere('kode_roll', 'like', '%'.$request->search.'%');
                });
        }

        // Apply inventory filter
        if ($request->inventory_filter && $request->inventory_filter != '') {
            $bbkRollsQuery = $bbkRollsQuery->where('inventory_id', $request->inventory_filter);
        }

        // Apply date filter
        if ($request->tanggal_from) {
            $bbkRollsQuery = $bbkRollsQuery->whereDate('tanggal_bbk', '>=', $request->tanggal_from);
        }

        if ($request->tanggal_to) {
            $bbkRollsQuery = $bbkRollsQuery->whereDate('tanggal_bbk', '<=', $request->tanggal_to);
        }

        // Get all BBK Rolls and group them by BBK number
        $allBbkRolls = $bbkRollsQuery->orderBy('bbk_number', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        
        // Group by BBK number while maintaining order
        $groupedBbkRolls = $allBbkRolls->groupBy('bbk_number');
        
        // Convert grouped collection to a flat array for pagination but maintain grouping
        $groupsArray = collect();
        foreach ($groupedBbkRolls as $bbkNumber => $group) {
            $groupsArray->push($group);
        }
        
        // Manual pagination on groups
        $page = $request->get('page', 1);
        $perPage = 10; // Reduced per page since we show multiple rows per group
        $offset = ($page - 1) * $perPage;
        $paginatedGroups = $groupsArray->slice($offset, $perPage);
        
        // Create paginator
        $bbkRolls = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedGroups,
            $groupsArray->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );
        
        // Add query parameters to pagination links
        $bbkRolls->appends($request->query());
        
        // Get data for filters
        $inventories = Inventory::with('supplier')->orderBy('kode_internal')->get();

        $data = [
            'bbkRolls' => $bbkRolls,
            'inventories' => $inventories
        ];

        return view('admin.bbk-roll.index', $data);
    }

    public function create()
    {
        // No need to load all inventories here anymore - they will be loaded via AJAX
        $data = [
            // Empty data - inventories will be loaded via pagination API
        ];

        return view('admin.bbk-roll.create', $data);
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'inventory_id' => 'required|array|min:1',
            'inventory_id.*' => 'exists:inventories,id',
            'inventory_keluar' => 'required|array',
            'inventory_keluar.*' => 'required|numeric|min:0',
            'tanggal_bbk' => 'required|date',
            'kembali' => 'nullable|integer|min:0',
            'opi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            // Generate BBK number
            $bbkNumber = $this->generateBbkNumberInternal($request->tanggal_bbk);
            
            $totalKeluar = 0;
            $createdBbkRolls = [];

            // Create BBK Roll entry for each selected inventory
            foreach ($request->inventory_id as $inventoryId) {
                $keluar = $request->inventory_keluar[$inventoryId] ?? 0;
                $opi = $request->inventory_opi[$inventoryId] ?? '';
                $keterangan = $request->inventory_keterangan[$inventoryId] ?? '';
                
                if ($keluar > 0) {
                    $bbkRoll = BbkRoll::create([
                        'bbk_number' => $request->bbk_number,
                        'inventory_id' => $inventoryId,
                        'tanggal_bbk' => $request->tanggal_bbk,
                        'keluar' => $keluar,
                        'kembali' => 0, // Initial kembali for individual entries
                        'opi' => $opi,
                        'keterangan' => $keterangan,
                        'created_by' => auth()->user()->name ?? 'System'
                    ]);
                    
                    $createdBbkRolls[] = $bbkRoll;
                    $totalKeluar += $keluar;
                }

                // Update inventory quantity
                if ($keluar > 0) {
                    $inventory = Inventory::find($inventoryId);
                    if ($inventory) {
                        $newQuantity = max(0, $inventory->quantity - $keluar);
                        $inventory->quantity = $newQuantity;
                        $inventory->save();
                    }
                }
            }

            // Update kembali proportionally if provided
            if ($request->kembali > 0 && $totalKeluar > 0) {
                foreach ($createdBbkRolls as $bbkRoll) {
                    $proportion = $bbkRoll->keluar / $totalKeluar;
                    $proportionalKembali = round($request->kembali * $proportion);
                    $bbkRoll->update(['kembali' => $proportionalKembali]);
                }
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'BBK Roll berhasil ditambahkan untuk ' . count($createdBbkRolls) . ' inventory.'
                ]);
            }

            return redirect()->route('bbk-roll.index')
                ->with('success', 'BBK Roll berhasil ditambahkan untuk ' . count($createdBbkRolls) . ' inventory.');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(BbkRoll $bbkRoll)
    {
        $bbkRoll->load(['inventory.supplier']);
        
        $data = [
            'bbkRoll' => $bbkRoll
        ];

        return view('admin.bbk-roll.show', $data);
    }

    public function edit(BbkRoll $bbkRoll)
    {
        $inventories = Inventory::with('supplier')->orderBy('kode_internal')->get();

        $data = [
            'bbkRoll' => $bbkRoll,
            'inventories' => $inventories
        ];

        return view('admin.bbk-roll.edit', $data);
    }

    public function update(Request $request, BbkRoll $bbkRoll)
    {
        $request->validate([
            'bbk_number' => 'required|string|unique:bbk_rolls,bbk_number,' . $bbkRoll->id,
            'inventory_id' => 'required|exists:inventories,id',
            'tanggal_bbk' => 'required|date',
            'keluar' => 'required|integer|min:1',
            'kembali' => 'nullable|integer|min:0',
            'opi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500'
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->user()->name ?? 'System';
        
        $bbkRoll->update($data);

        return redirect()->route('bbk-roll.index')
            ->with('success', 'BBK Roll berhasil diperbarui.');
    }

    public function destroy(BbkRoll $bbkRoll)
    {
        $bbkRoll->delete();

        return redirect()->route('bbk-roll.index')
            ->with('success', 'BBK Roll berhasil dihapus.');
    }

    // Generate BBK Number for API
    public function generateBbkNumber()
    {
        $currentYear = Carbon::now()->format('Y');
        $currentMonth = Carbon::now()->format('m');
        
        // Format: BBK-YYYY-MM-XXXX
        $prefix = "BBK-{$currentYear}-{$currentMonth}-";
        
        // Get last BBK number for current month
        $lastBbk = BbkRoll::where('bbk_number', 'like', $prefix . '%')
            ->orderBy('bbk_number', 'desc')
            ->withTrashed() // Include soft-deleted records
            ->first();
        
        if ($lastBbk) {
            $lastNumber = (int) substr($lastBbk->bbk_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        
        
        $bbkNumber = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        return response()->json([
            'success' => true,
            'bbk_number' => $bbkNumber
        ]);
    }

    // Internal method to generate BBK number
    private function generateBbkNumberInternal($tanggal = null)
    {
        $date = $tanggal ? Carbon::parse($tanggal) : Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        
        // Format: BBK-YYYY-MM-XXXX
        $prefix = "BBK-{$year}-{$month}-";
        
        // Get last BBK number for the specified month
        $lastBbk = BbkRoll::where('bbk_number', 'like', $prefix . '%')
            ->orderBy('bbk_number', 'desc')
            ->first();
        
        if ($lastBbk) {
            $lastNumber = (int) substr($lastBbk->bbk_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function showGroup($bbkNumber)
    {
        $bbkRolls = BbkRoll::where('bbk_number', $bbkNumber)
            ->with(['inventory.supplier'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($bbkRolls->isEmpty()) {
            return redirect()->route('bbk-roll.index')
                ->with('error', 'BBK Roll dengan nomor ' . $bbkNumber . ' tidak ditemukan.');
        }

        $data = [
            'bbkRolls' => $bbkRolls,
            'bbkNumber' => $bbkNumber
        ];

        return view('admin.bbk-roll.show-group', $data);
    }

    public function editGroup($bbkNumber)
    {
        $bbkRolls = BbkRoll::where('bbk_number', $bbkNumber)
            ->with(['inventory.supplier'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($bbkRolls->isEmpty()) {
            return redirect()->route('bbk-roll.index')
                ->with('error', 'BBK Roll dengan nomor ' . $bbkNumber . ' tidak ditemukan.');
        }

        // Get inventories for dropdown - only show inventory with quantity > 0
        $inventories = Inventory::with('supplier')
                                ->where('quantity', '>', 0)
                                ->orderBy('kode_internal')
                                ->get();

        $data = [
            'bbkRolls' => $bbkRolls,
            'bbkNumber' => $bbkNumber,
            'inventories' => $inventories
        ];

        return view('admin.bbk-roll.edit-group', $data);
    }

    public function updateGroup(Request $request, $bbkNumber)
    {
        $request->validate([
            'tanggal_bbk' => 'required|date',
            'bbk_roll_ids' => 'array',
            'bbk_roll_ids.*' => 'exists:bbk_rolls,id',
            'inventory_kembali' => 'array',
            'inventory_kembali.*' => 'nullable|numeric|min:0',
            'inventory_opi' => 'array',
            'inventory_opi.*' => 'nullable|string|max:255',
            'inventory_keterangan' => 'array',
            'inventory_keterangan.*' => 'nullable|string|max:500',
            // New inventory validation
            'new_inventory_ids' => 'array',
            'new_inventory_ids.*' => 'exists:inventories,id',
            'new_inventory_keluar' => 'array',
            'new_inventory_keluar.*' => 'required|numeric|min:0.01',
            'new_inventory_kembali' => 'array',
            'new_inventory_kembali.*' => 'nullable|numeric|min:0',
            'new_inventory_opi' => 'array',
            'new_inventory_opi.*' => 'nullable|string|max:255',
            'new_inventory_keterangan' => 'array',
            'new_inventory_keterangan.*' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            // Update existing BBK Rolls
            if ($request->bbk_roll_ids) {
                foreach ($request->bbk_roll_ids as $index => $bbkRollId) {
                    $kembali = $request->inventory_kembali_rasio[$index] != '-' ? $request->inventory_kembali_rasio[$index] : $request->inventory_kembali[$index];
                    $opi = $request->inventory_opi[$index] ?? '';
                    $keterangan = $request->inventory_keterangan[$index] ?? '';
                    
                    $bbkRoll = BbkRoll::where('id', $bbkRollId)
                                      ->where('bbk_number', $bbkNumber)
                                      ->first();
                    
                    if ($bbkRoll) {
                        // Get the old kembali value before updating
                        $oldKembali = $bbkRoll->kembali;
                        
                        // Update BBK Roll
                        $bbkRoll->update([
                            'tanggal_bbk' => $request->tanggal_bbk,
                            'kembali' => $kembali,
                            'opi' => $opi,
                            'keterangan' => $keterangan,
                            'updated_by' => auth()->user()->name ?? 'System'
                        ]);

                        // Only adjust inventory if kembali value has changed
                        $kembaliDifference = $kembali - $oldKembali;
                        if ($kembaliDifference != 0) {
                            $inventory = Inventory::find($bbkRoll->inventory_id);
                            if ($inventory) {
                                // Add the difference to inventory quantity
                                // Positive difference = more returned = more inventory
                                // Negative difference = less returned = less inventory
                                $inventory->quantity += $kembaliDifference;
                                $inventory->save();
                            }
                        }
                    }
                }
            }

            // Add new inventories to BBK Roll
            if ($request->new_inventory_ids) {
                foreach ($request->new_inventory_ids as $index => $inventoryId) {
                    $keluar = $request->new_inventory_keluar[$index] ?? 0;
                    $kembali = $request->new_inventory_kembali[$index] ?? 0;
                    $opi = $request->new_inventory_opi[$index] ?? '';
                    $keterangan = $request->new_inventory_keterangan[$index] ?? '';

                    // Check if inventory has enough quantity
                    $inventory = Inventory::find($inventoryId);
                    if (!$inventory || $inventory->quantity < $keluar) {
                        throw new \Exception("Inventory {$inventory->kode_internal} tidak memiliki stok yang cukup. Stok tersedia: {$inventory->quantity}");
                    }

                    // Create new BBK Roll entry
                    BbkRoll::create([
                        'bbk_number' => $bbkNumber,
                        'tanggal_bbk' => $request->tanggal_bbk,
                        'inventory_id' => $inventoryId,
                        'keluar' => $keluar,
                        'kembali' => $kembali,
                        'opi' => $opi,
                        'keterangan' => $keterangan,
                        'created_by' => auth()->user()->name ?? 'System'
                    ]);

                    // Reduce inventory quantity
                    $inventory->quantity -= $keluar;
                    $inventory->save();
                }
            }

            DB::commit();

            return redirect()->route('bbk-roll.index')
                ->with('success', 'BBK Roll group berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroyGroup($bbkNumber)
    {
        $bbkRolls = BbkRoll::where('bbk_number', $bbkNumber)->get();

        if ($bbkRolls->isEmpty()) {
            return redirect()->route('bbk-roll.index')
                ->with('error', 'BBK Roll dengan nomor ' . $bbkNumber . ' tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            // Restore inventory quantities
            foreach ($bbkRolls as $bbkRoll) {
                $inventory = Inventory::find($bbkRoll->inventory_id);
                if ($inventory) {
                    $inventory->quantity += $bbkRoll->keluar;
                    $inventory->save();
                }
            }

            // Delete all BBK Rolls with this number
            BbkRoll::where('bbk_number', $bbkNumber)->delete();

            DB::commit();

            return redirect()->route('bbk-roll.index')
                ->with('success', 'Semua BBK Roll dengan nomor ' . $bbkNumber . ' berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('bbk-roll.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // API endpoint to get inventory details
    public function getInventoryDetails($id)
    {
        $inventory = Inventory::with('supplier')->find($id);
        
        if (!$inventory) {
            return response()->json(['error' => 'Inventory not found'], 404);
        }

        return response()->json([
            'id' => $inventory->id,
            'kode_internal' => $inventory->kode_internal,
            'kode_roll' => $inventory->kode_roll,
            'jenis' => $inventory->jenis,
            'gsm' => $inventory->gsm,
            'lebar' => $inventory->lebar,
            'quantity' => $inventory->quantity,
            'supplier' => $inventory->supplier ? $inventory->supplier->name : '-'
        ]);
    }

    // Delete individual BBK Roll item
    public function deleteItem($bbkRollId)
    {
        DB::beginTransaction();

        try {
            $bbkRoll = BbkRoll::find($bbkRollId);
            
            if (!$bbkRoll) {
                return response()->json([
                    'success' => false,
                    'message' => 'BBK Roll item tidak ditemukan.'
                ], 404);
            }

            // Check if user has permission (optional - you can add authorization here)
            // $this->authorize('delete', $bbkRoll);

            $inventoryName = $bbkRoll->inventory->kode_internal ?? 'Unknown';
            
            // Restore inventory quantity
            $inventory = Inventory::find($bbkRoll->inventory_id);
            if ($inventory) {
                // Return the quantity that was taken out (keluar - kembali)
                $returnQuantity = $bbkRoll->keluar - $bbkRoll->kembali;
                $inventory->quantity += $returnQuantity;
                $inventory->save();
            }
            
            // Delete the BBK Roll record
            $bbkRoll->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Inventory \"{$inventoryName}\" berhasil dihapus dari BBK Roll dan dikembalikan ke stok."
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
