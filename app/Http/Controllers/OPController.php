<?php

namespace App\Http\Controllers;

use App\Models\OPBJ;
use App\Models\OPRoll;
use App\Models\OPSheet;
use App\Models\OPTeknik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OPController extends Controller
{
    public function index()
    {
        $sheet = DB::connection('firebird3')->table('TBarang')
        ->where('KodeBrg', 'LIKE', '%11.18%')
        ->orWhere('KodeBrg', 'LIKE', '%11.19%')
        ->get();

        $roll = DB::connection('firebird3')->table('TBarang')
            ->where('KodeBrg', 'LIKE', '%11.11%')
            ->orWhere('KodeBrg', 'LIKE', '%11.12%')
            ->orWhere('KodeBrg', 'LIKE', '%11.13%')
            ->orWhere('KodeBrg', 'LIKE', '%11.14%')
            ->orWhere('KodeBrg', 'LIKE', '%11.15%')
            ->orWhere('KodeBrg', 'LIKE', '%11.16%')
            ->orderBy('KodeBrg', 'asc')
            ->get();

        $bj = DB::connection('firebird2')->table('TBarangConv')
        ->orderBy('KodeBrg', 'asc')
        ->get();    

        $teknik = DB::connection('fbteknik')->table('TBarang')
            ->orderBy('KodeBrg', 'asc')
            ->get();

        return view('admin.opname.index', compact(
            'sheet',
            'roll',
            'bj',
            'teknik'
        ));

        // dd($sheet);
    }

    // Opname Sheet
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


        $OPSheet = OPSheet::create([
            'kode_barang' => $kode,
            'nama' => $request->namabrg,
            'periode' => $periode,
            'out' => $request->out,
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

    public function resultOpSheet()
    {
        $opsheet = DB::table('opname_sheet')->get();

        return view('admin.opname.opsheet.result', compact('opsheet'));
    }

    // Opname Roll

    public function indexOpRoll()
    {
        $roll = DB::connection('firebird3')->table('TBarang')
            ->where('KodeBrg', 'LIKE', '%11.11%')
            ->orWhere('KodeBrg', 'LIKE', '%11.12%')
            ->orWhere('KodeBrg', 'LIKE', '%11.13%')
            ->orWhere('KodeBrg', 'LIKE', '%11.14%')
            ->orWhere('KodeBrg', 'LIKE', '%11.15%')
            ->orWhere('KodeBrg', 'LIKE', '%11.16%')
            ->orderBy('KodeBrg', 'asc')
            ->get();

        return view('admin.opname.oproll.index', compact('roll'));
    }

    public function createOpRoll()
    {
        return view('admin.opname.oproll.create');
    }

    public function editOpRoll($KodeBrg)
    {
        $roll = DB::connection('firebird3')->table('TBarang')
            ->where('KodeBrg', '=', $KodeBrg)
            ->first();

        // dd($roll->KodeBrg);
        return view('admin.opname.oproll.edit', compact('roll'));
    }

    public function storeOpRoll(Request $request)
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

        $OPRoll = OPRoll::create([
            'kode' => $kode,
            'nama' => $request->namabrg,
            'periode' => $periode,
            'gudang' => $request->gudang,
            'opname_kg' => $request->opnamekg,
            'opname_pcs' => $request->opnamepcs,
            'createdBy' => $request->createdBy
        ]);

        // dd($OProll);
        // // dd($request->simpan);
        if ($request->simpan == 'back') {
            return redirect('admin/opname/roll');
        } else 
        if ($request->simpan == 'save') {
            return $this->editOpRoll($kode);
        }
    }

    public function resultOpRoll()
    {
        $oproll = DB::table('opname_roll')
            ->orderBy('kode', 'asc')
            ->get();

        return view('admin.opname.oproll.result', compact('oproll'));
    }

    // Opname Barang Jadi

    public function indexOpBJ()
    {
        $bj = DB::connection('firebird2')->table('TBarangConv')
            ->orderBy('KodeBrg', 'asc')
            ->get();

        return view('admin.opname.opbj.index', compact('bj'));
    }

    public function createOpBJ()
    {
        return view('admin.opname.opbj.create');
    }

    public function editOpBJ($KodeBrg)
    {
        $bj = DB::connection('firebird2')->table('TBarangConv')
            ->where('KodeBrg', '=', $KodeBrg)
            ->first();

        // dd($bj->KodeBrg);
        return view('admin.opname.opbj.edit', compact('bj'));
    }

    public function storeOpBJ(Request $request)
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

        $OPBJ = OPBJ::create([
            'kode' => $kode,
            'nama' => $request->namabrg,
            'periode' => $periode,
            'gudang' => $request->gudang,
            'opname_koli' => $request->opnamekoli,
            'per_koli' => $request->perkoli,
            'opname_pcs' => $request->opnamepcs,
            'createdBy' => $request->createdBy
        ]);

        // dd($OPBJ);
        // // dd($request->simpan);
        if ($request->simpan == 'back') {
            return redirect('admin/opname/bj');
        } else 
        if ($request->simpan == 'save') {
            return $this->editOpBJ($kode);
        }
    }

    public function resultOpBJ()
    {
        $opbj = DB::table('opname_bj')
            ->orderBy('kode', 'asc')
            ->get();

        return view('admin.opname.opbj.result', compact('opbj'));
    }

    // Opname Teknik

    public function indexOpTeknik()
    {
        $teknik = DB::connection('fbteknik')->table('TBarang')
            ->orderBy('KodeBrg', 'asc')
            ->get();

        return view('admin.opname.opteknik.index', compact('teknik'));
    }

    public function createOpTeknik()
    {
        return view('admin.opname.opteknik.create');
    }

    public function editOpTeknik($KodeBrg)
    {
        $teknik = DB::connection('fbteknik')->table('TBarang')
            ->where('KodeBrg', '=', $KodeBrg)
            ->first();

        // dd($teknik->KodeBrg);
        return view('admin.opname.opteknik.edit', compact('teknik'));
    }

    public function storeOpTeknik(Request $request)
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

        $OPTeknik = OPTeknik::create([
            'kode' => $kode,
            'nama' => $request->namabrg,
            'periode' => $periode,
            'satuan' => $request->satuan,
            'opname_pcs' => $request->opnamepcs,
            'createdBy' => $request->createdBy
        ]);

        // dd($OPTeknik);
        // // dd($request->simpan);
        if ($request->simpan == 'back') {
            return redirect('admin/opname/teknik');
        } else 
        if ($request->simpan == 'save') {
            return $this->editOpTeknik($kode);
        }
    }

    public function resultOpTeknik()
    {
        $opteknik = DB::table('opname_teknik')
            ->orderBy('kode', 'asc')
            ->get();

        return view('admin.opname.opteknik.result', compact('opteknik'));
    }
}
