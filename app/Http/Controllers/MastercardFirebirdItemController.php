<?php

namespace App\Http\Controllers;

use App\Models\Mastercard;
use App\Models\Tracking;
use App\Services\MastercardFirebirdItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class MastercardFirebirdItemController extends Controller
{
    public function store(Request $request, $id, MastercardFirebirdItemService $service)
    {
        abort_unless(hasMenuAccess('mastercard'), 403);
        $mastercard = Mastercard::findOrFail($id);
        $input = $request->validate([
            'satuan' => ['required', Rule::in(['PCS', 'KG', 'SET', 'ROLL', 'BDL', 'CRT', 'SACK'])],
            'isi' => 'required|numeric|min:0',
            'berat' => 'required|numeric|min:0',
            'beratcrt' => 'required|numeric|min:0',
            'hargajual' => 'required|numeric|min:0',
            'hargausd' => 'required|numeric|min:0',
            'confirmed_kode' => 'required|string',
            'confirmed_nama' => 'required|string',
        ]);
        if ($input['confirmed_kode'] !== $mastercard->kodeBarang || $input['confirmed_nama'] !== $mastercard->namaBarang) {
            return back()->withInput()->withErrors(['generate' => 'Data Mastercard berubah. Muat ulang halaman dan periksa kembali sebelum generate.']);
        }
        $context = ['mastercard_id' => $mastercard->id, 'kode_barang' => $mastercard->kodeBarang, 'user_id' => $request->user()->id];
        Log::info('Percobaan generate barang Firebird dari Mastercard.', $context);

        try {
            $alreadyGenerated = DB::table('mastercard_firebird_generations')
                ->where('kode_barang', trim($mastercard->kodeBarang))->exists();
        } catch (\PDOException $exception) {
            Log::error('Status generate barang tidak dapat diperiksa.', $context + ['exception' => $exception]);
            return back()->withInput()->withErrors(['generate' => 'Status generate tidak dapat diperiksa. Hubungi administrator sebelum mencoba lagi.']);
        }
        if ($alreadyGenerated) {
            return back()->withInput()->withErrors(['generate' => 'Kode barang ini sudah tercatat pernah digenerate. Tidak ada data yang diubah.']);
        }

        try {
            $service->generate(DB::connection('firebird2'), $mastercard, $input);
        } catch (\PDOException $exception) {
            Log::error('Generate barang Firebird gagal.', $context + ['exception' => $exception]);
            return back()->withInput()->withErrors(['generate' => 'Terjadi kesalahan Firebird. Periksa apakah barang sudah dibuat sebelum mencoba lagi; detail tersedia di log server.']);
        }

        Log::info('Barang Firebird berhasil dibuat dari Mastercard.', $context);
        try {
            DB::table('mastercard_firebird_generations')->insert([
                'kode_barang' => trim($mastercard->kodeBarang),
                'mastercard_id' => $mastercard->id,
                'user_id' => $request->user()->id,
                'generated_at' => now(),
            ]);
        } catch (\PDOException $exception) {
            Log::error('Barang Firebird dibuat tetapi status generate gagal disimpan.', $context + ['exception' => $exception]);
            return back()->with('generate_warning', 'Barang berhasil dibuat di Firebird, tetapi status generate gagal disimpan. Jangan generate ulang; hubungi administrator.');
        }
        try {
            Tracking::create([
                'user' => $request->user()->name, 'tipe' => 'Mastercard',
                'event' => 'Generate barang Firebird ' . $mastercard->kodeBarang,
                'before' => '-', 'after' => 'Mastercard ID: ' . $mastercard->id . ', Kode barang: ' . $mastercard->kodeBarang,
            ]);
        } catch (\PDOException $exception) {
            Log::error('Barang Firebird dibuat tetapi tracking gagal disimpan.', $context + ['exception' => $exception]);
            return back()->with('generate_warning', 'Barang berhasil dibuat di Firebird, tetapi pencatatan tracking gagal. Jangan generate ulang; hubungi administrator.');
        }

        return back()->with('generate_success', 'Barang ' . $mastercard->kodeBarang . ' berhasil dibuat di Firebird.');
    }
}
