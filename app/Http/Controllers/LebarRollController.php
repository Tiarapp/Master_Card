<?php

namespace App\Http\Controllers;

use App\Models\LebarRoll;
use Illuminate\Http\Request;

class LebarRollController extends Controller
{
    public function index(Request $request)
    {
        $lebar = LebarRoll::query();

        if ($request->search) {
            $lebar = $lebar->where('name', 'like', '%' . $request->search . '%');
        }

        $lebar = $lebar->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.inventory.lebar.index', compact('lebar'));
    }

    public function create()
    {
        return view('admin.inventory.lebar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:lebar_rolls,name',
        ]);

        $lebar = new LebarRoll();
        $lebar->name = $request->name;
        $lebar->save();

        return redirect()->route('lebar-roll.index')->with('success', 'Lebar berhasil ditambahkan!');
    }

    public function show(LebarRoll $lebarRoll)
    {
        return view('admin.inventory.lebar.show', compact('lebarRoll'));
    }

    public function edit(LebarRoll $lebarRoll)
    {
        return view('admin.inventory.lebar.edit', compact('lebarRoll'));
    }

    public function update(Request $request, LebarRoll $lebarRoll)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:lebar_rolls,name,' . $lebarRoll->id,
        ]);

        $lebarRoll->update([
            'name' => $request->name,
        ]);

        return redirect()->route('lebar-roll.index')->with('success', 'Lebar berhasil diperbarui!');
    }

    public function destroy(LebarRoll $lebarRoll)
    {
        $lebarRoll->delete();

        return redirect()->route('lebar-roll.index')->with('success', 'Lebar berhasil dihapus!');
    }
}
