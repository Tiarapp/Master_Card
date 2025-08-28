<?php

namespace App\Http\Controllers;

use App\Models\Potongan;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PotongController extends Controller
{
    public function index(Request $request)
    {
        $potongs = new Potongan();
        $potongs = $potongs->with(['inventory.supplier']);

        // Apply search filter
        if ($request->search) {
            $potongs = $potongs->whereHas('inventory', function ($query) use ($request) {
                $query->where('kode_internal', 'like', '%'.$request->search.'%')
                    ->orWhere('kode_roll', 'like', '%'.$request->search.'%');
            })
            ->orWhere('lebar_potongan', 'like', '%'.$request->search.'%')
            ->orWhere('keterangan', 'like', '%'.$request->search.'%');
        }

        // Apply inventory filter
        if ($request->inventory_filter && $request->inventory_filter != '') {
            $potongs = $potongs->where('inventory_id', $request->inventory_filter);
        }

        $potongs = $potongs->orderBy('created_at', 'desc')->paginate(20);
        
        // Get data for filters
        $inventories = Inventory::with('supplier')->orderBy('kode_internal')->get();

        $data = [
            'potongs' => $potongs,
            'inventories' => $inventories
        ];

        return view('admin.potongan.index', $data);
    }

    public function create()
    {
        // Get inventories for dropdown
        $inventories = Inventory::with('supplier')->orderBy('kode_internal')->get();

        $data = [
            'inventories' => $inventories
        ];

        return view('admin.potongan.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lebar_potongan' => 'required|integer|min:1',
            'rasio' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            // Create potongan
            $potongan = Potongan::create($request->all());

            // Update inventory dengan potongan_id
            $inventory = Inventory::findOrFail($request->inventory_id);
            $inventory->potongan_id = $potongan->id;
            $inventory->descoription = $request->keterangan;
            $inventory->save();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Potongan berhasil ditambahkan dan terhubung dengan inventory.'
                ]);
            }

            return redirect()->route('potongan.index')
                ->with('success', 'Potongan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Potongan $potongan)
    {
        $potongan->load(['inventory.supplier']);
        
        $data = [
            'potongan' => $potongan
        ];

        return view('admin.potongan.show', $data);
    }

    public function edit(Potongan $potongan)
    {
        $inventories = Inventory::with('supplier')->orderBy('kode_internal')->get();

        $data = [
            'potongan' => $potongan,
            'inventories' => $inventories
        ];

        return view('admin.potongan.edit', $data);
    }

    public function update(Request $request, Potongan $potongan)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'lebar_potongan' => 'required|integer|min:1',
            'rasio' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $potongan->update($request->all());

        return redirect()->route('potongan.index')
            ->with('success', 'Potongan berhasil diperbarui.');
    }

    public function destroy(Potongan $potongan)
    {
        // Update inventory to remove potongan_id reference
        $inventory = Inventory::where('potongan_id', $potongan->id)->first();
        if ($inventory) {
            $inventory->potongan_id = null;
            $inventory->save();
        }

        $potongan->delete();

        return redirect()->route('potongan.index')
            ->with('success', 'Potongan berhasil dihapus.');
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
            'supplier' => $inventory->supplier ? $inventory->supplier->name : '-'
        ]);
    }
}