<?php

namespace App\Http\Controllers;

use App\Models\PaletMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaletMutasiController extends Controller
{
    public function index(Request $request)
    {
        $query = PaletMutasi::aktif()->with('palet')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('customer')) {
            $query->where('namaCustomer', 'LIKE', '%' . $request->customer . '%');
        }
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $mutasi = $query->paginate(50)->appends($request->query());

        // Saldo = palet keluar - palet masuk, yaitu palet yang masih ada di customer
        $saldoQuery = DB::table('palet_mutasi')
            ->join('item_palet', 'palet_mutasi.item_palet_id', '=', 'item_palet.id')
            ->whereNull('palet_mutasi.deletedAt')
            ->groupBy('palet_mutasi.namaCustomer', 'item_palet.id', 'item_palet.nama', 'item_palet.ukuran')
            ->orderBy('palet_mutasi.namaCustomer')
            ->selectRaw("palet_mutasi.namaCustomer, item_palet.nama as palet, item_palet.ukuran,
                SUM(CASE WHEN palet_mutasi.jenis = 'keluar' THEN palet_mutasi.qty ELSE 0 END) as total_keluar,
                SUM(CASE WHEN palet_mutasi.jenis = 'masuk' THEN palet_mutasi.qty ELSE 0 END) as total_masuk");

        if ($request->filled('customer')) {
            $saldoQuery->where('palet_mutasi.namaCustomer', 'LIKE', '%' . $request->customer . '%');
        }

        $saldo = $saldoQuery->get();

        return view('admin.palet_mutasi.index', compact('mutasi', 'saldo'));
    }

    public function create(Request $request)
    {
        $jenis = $request->get('jenis') === PaletMutasi::MASUK ? PaletMutasi::MASUK : PaletMutasi::KELUAR;
        $customer = DB::connection('firebird')->table('TCustomer')->orderBy('Nama')->pluck('Nama');
        $palet = DB::table('item_palet')->whereNull('deletedAt')->orderBy('nama')->get();

        return view('admin.palet_mutasi.create', compact('jenis', 'customer', 'palet'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:keluar,masuk',
            'namaCustomer' => 'required|string|max:255',
            'item_palet_id' => 'required|exists:item_palet,id',
            'qty' => 'required|integer|min:1',
            'noDokumen' => 'nullable|string|max:255',
            'noPolisi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        PaletMutasi::create($data + ['createdBy' => Auth::user()->name]);

        $label = $data['jenis'] === PaletMutasi::KELUAR ? 'keluar ke customer' : 'masuk dari customer';

        return redirect()->route('palet_mutasi')->with('success', "Palet {$label} berhasil dicatat.");
    }

    public function destroy($id)
    {
        $mutasi = PaletMutasi::aktif()->findOrFail($id);
        $mutasi->update([
            'deletedAt' => now(),
            'deletedBy' => Auth::user()->name,
        ]);

        return redirect()->route('palet_mutasi')->with('success', 'Catatan palet dihapus.');
    }
}
