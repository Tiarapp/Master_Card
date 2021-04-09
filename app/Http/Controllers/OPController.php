<?php

namespace App\Http\Controllers;

use App\Models\OPSheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OPController extends Controller
{
    public function index()
    {
        return view('admin.opname.index');
    }

    public function indexopSheet()
    {
        $sheet = DB::connection('firebird3')->table('TBarang')
            ->where('KodeBrg', 'LIKE', '%11.18%')
            ->orWhere('KodeBrg', 'LIKE', '%11.19%')
            ->get();

        return view('admin.opname.opsheet.index', compact('sheet'));
    }

    public function createOpSheet()
    {
        $flute = DB::table('flute')->get();

        return view('admin.opname.opsheet.create', compact('flute'));
    }

    public function editOpSheet($KodeBrg)
    {
        $sheet = DB::connection('firebird3')->table('TBarang')
            ->where('KodeBrg', '=', $KodeBrg)
            ->first();
        $flute = DB::table('flute')->get();

        // dd($sheet->KodeBrg);
        return view('admin.opname.opsheet.edit', compact('sheet','flute'));
    }

    public function storeOpSheet(Request $request)
    {
        $year = date('Y');
        $month = date('m');

        $periode = "$month/$year";

        if ($request->kodebrg === null) {
            $kode = 'Barang Baru';
        } else {
            $kode = $request->kodebrg;
        }

        // dd($periode);
        // $request->validate([
        //     'kode_barang' => 'required',
        //     'nama' => 'required',
        //     'periode' => 'requred',
        //     'gudang' => 'required',
        //     'flute' => 'required',
        //     'opname' => 'required',
        //     'createdBy' => 'required',
        // ]);

        $OPSheet = OPSheet::create([
            'kode_barang' => $kode,
            'nama' => $request->namabrg,
            'periode' => $periode,
            'gudang' => $request->gudang,
            'flute' => $request->flute,
            'opname_dm' => $request->opnamedm,
            'opname_pcs' => $request->opnamepcs,
            'createdBy' => $request->createdBy
        ]);

        // dd($OPSheet);
        // // dd($request->simpan);
        if ($request->simpan == 'back') {
            return redirect('admin/opname/sheet');
        } else 
        if ($request->simpan == 'save') {
            return $this->editOpSheet($kode);
        }
    }
}
