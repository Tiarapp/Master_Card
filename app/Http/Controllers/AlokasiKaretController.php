<?php

namespace App\Http\Controllers;

use App\Exports\AlokasiKaretExport;
use App\Models\AlokasiKaret;
use App\Models\BbmTeknik;
use App\Models\Karet;
use App\Models\Mastercard;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AlokasiKaretController extends Controller
{
    public function index(Request $request)
    {
        $alokasi = new Karet();
        $alokasi = $alokasi->with('mastercard');

        if ($request->search) {
            $alokasi = $alokasi->where('customer', 'like', '%' . $request->search . '%')
                ->orWhere('nama_karet', 'like', '%' . $request->search . '%');
        }

        //FIlter Sales
        if ($request->sales_name) {
            $alokasi = $alokasi->where('sales_name', $request->sales_name);
        }

        $alokasi = $alokasi->orderBy('id', 'asc')->paginate(20);

        $data = [
            'alokasi' => $alokasi
        ];
        return view('admin.alokasi_karet.index', $data);
    }

    public function create()
    {
        $sales = Sales::where("aktif", 1)->get();

        $data = [
            'sales' => $sales
        ];

        return view('admin.alokasi_karet.create', $data);
    }

    public function show($id)
    {
        $karet = Karet::with(['mastercard', 'alokasiKarets'])->findOrFail($id);
        
        // Get all transactions for this karet
        $transaksi = AlokasiKaret::where('karet_id', $id)
                                ->orderBy('tanggal_kirim', 'desc')
                                ->get();
        
        // Group transactions by month
        $transaksiPerBulan = $transaksi->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->tanggal_kirim)->format('Y-m');
        })->map(function($group) {
            return [
                'bulan' => \Carbon\Carbon::parse($group->first()->tanggal_kirim)->format('F Y'),
                'transaksi' => $group,
                'total_pcs' => $group->sum('pcs'),
                'total_harga' => $group->sum('alokasi_harga')
            ];
        });
        
        $data = [
            'karet' => $karet,
            'transaksi' => $transaksi,
            'transaksiPerBulan' => $transaksiPerBulan
        ];
        
        return view('admin.alokasi_karet.show', $data);
    }

    public function export(Request $request)
    {
        $fileName = 'alokasi-karet-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(
            new AlokasiKaretExport($request->search, $request->sales_name), 
            $fileName
        );
    }

    public function store(Request $request)
    {
        // Debug: Log all request data
        Log::info('Store Request Data:', $request->all());
        
        // Validation rules
        $validator = Validator::make($request->all(), [
            'tipe' => 'required|in:Karet,Pisau',
            'nama_karet' => 'required|string|max:255',
            'mc_kode' => 'required|string|max:255',
            'sales_name' => 'required|string|max:255',
            'kontrak_id' => 'required',
            'customer_display' => 'required|string|max:255',
            'bbm_id' => 'required',
            'tanggal' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'gsm' => 'required|numeric|min:0',
            'per_kg' => 'required|numeric|min:0',
            'alokasi' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            

            // Create new Karet record
            $karet = new Karet();
            $karet->mc_id = $request->mc_id; // Will be set if needed
            $karet->customer = $request->customer_display;
            $karet->sales_name = $request->sales_name;
            $karet->kode_barang = $request->kodebarang;
            $karet->nama_karet = $request->nama_karet;
            $karet->no_po = $request->nopo; // Store kontrak_id in no_po field
            $karet->gsm = $request->gsm;
            $karet->harga_per_kg = $request->per_kg;
            $karet->lokasi_kirim = $request->lokasi;
            $karet->tanggal_masuk = $request->tanggal;
            $karet->harga = $request->subtotal;

            // Additional fields not in the original model but might be needed
            $karet->type = $request->tipe;
            $karet->bbm_id = $request->bbm_id;
            $karet->alokasi = $request->alokasi;
            $karet->sisa = $request->subtotal;

            $karet->save();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data alokasi karet berhasil disimpan.',
                    'data' => $karet
                ]);
            }

            return redirect()->route('karet.index')
                ->with('success', 'Data alokasi karet berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }
}
