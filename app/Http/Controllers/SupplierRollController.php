<?php

namespace App\Http\Controllers;

use App\Models\SupplierRoll;
use Illuminate\Http\Request;

class SupplierRollController extends Controller
{
    public function index(Request $request)
    {
        $supplier = SupplierRoll::query();

        if ($request->search) {
            $supplier = $supplier->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        $supplier = $supplier->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.inventory.supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('admin.inventory.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
        ]);

        $supplier = new SupplierRoll();

        $supplier->name = $request->name;
        $supplier->code = $request->code;

        $supplier->save();

        return redirect()->route('supplier-roll.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function show($id)
    {
        $supplier = SupplierRoll::find($id);
        return response()->json($supplier);
    }

    public function edit(SupplierRoll $supplierRoll)
    {
        return view('admin.inventory.supplier.edit', compact('supplierRoll'));
    }

    public function update(Request $request, SupplierRoll $supplierRoll)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $supplierRoll->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('supplier-roll.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy(SupplierRoll $supplierRoll)
    {
        $supplierRoll->delete();

        return redirect()->route('supplier-roll.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
