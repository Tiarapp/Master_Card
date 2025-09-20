<?php

namespace App\Http\Controllers;

use App\Models\JenisRoll;
use Illuminate\Http\Request;

class JenisRollController extends Controller
{
    public function index(Request $request)
    {
        $jenis = JenisRoll::query();

        if ($request->search) {
            $jenis = $jenis->where('name', 'like', '%' . $request->search . '%');
        }

        $jenis = $jenis->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.inventory.jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('admin.inventory.jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_rolls,name',
            'gsm' => 'required|numeric|min:0',
        ]);

        $jenisroll = new JenisRoll();
        $jenisroll->name = $request->name;
        $jenisroll->gsm = $request->gsm;
        $jenisroll->save();

        return redirect()->route('jenis-roll.index')->with('success', 'Jenis berhasil ditambahkan!');
    }

    public function show($id)
    {
        $jenisroll = JenisRoll::findOrFail($id);

        return response()->json($jenisroll);
    }

    public function edit(JenisRoll $jenisRoll)
    {
        return view('admin.inventory.jenis.edit', compact('jenisRoll'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_rolls,name,' . $id
        ]);

        $jenisroll = JenisRoll::findOrFail($id);
        $jenisroll->name = $request->name;
        $jenisroll->gsm = $request->gsm;
        $jenisroll->save();

        return redirect()->route('jenis-roll.index')->with('success', 'Jenis berhasil diperbarui!');
    }

    public function destroy(JenisRoll $jenisRoll)
    {
        $jenisRoll->delete();

        return redirect()->route('jenis-roll.index')->with('success', 'Jenis berhasil dihapus!');
    }
}
