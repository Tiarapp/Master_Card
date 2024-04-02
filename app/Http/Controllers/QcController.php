<?php

namespace App\Http\Controllers;

use App\Models\Opi_M;
use App\Models\QcModel;
use Illuminate\Http\Request;

class QcController extends Controller
{
    public function index() {
        $data = QcModel::get();

        return view('admin.qc.index', compact('data'));
    }

    public function create() {
        $opi = Opi_M::opi2()
            // ->limit(5)
            ->where('periode', 'LIKE', '2024')
            ->get();

        return view('admin.qc.add', compact([
            'opi'
        ]));
    }

    public function store(Request $request) {
        // dd($request->all());

        $datapertanggl = QcModel::where('tanggal_analisa', '=', $request->tgl_analisa)->get();

        $temp = date_create($request->tgl_analisa);
        $day = date_format($temp, 'd-m-Y');

        $no_analisa = str_replace('-', '', $day). count($datapertanggl)+1;
        // dd($no_analisa);

        $data = QcModel::create([
            'tanggal_analisa' => $request->tgl_analisa,
            'opi_id' => $request->opiid,
            'mc' => $request->mc,
            'cust' => $request->cust,
            'item' => $request->item,
            'kwalitas' => $request->kualitas,
            'no_po' => $request->po_cust,
            'no_analisa' => $no_analisa,
            'no_batch' => $request->nobatch,
            'jumlah_kirim' => $request->jumlah_kirim,
            'tanggal_kirim' => $request->tglKirim,
            'berat1' => $request->berat1,
            'berat2' => $request->berat2,
            'berat3' => $request->berat3,
            'berat4' => $request->berat4,
            'berat5' => $request->berat5,
            'avg_berat' => $request->avg_berat,
            'bst1' => $request->bst1,
            'bst2' => $request->bst2,
            'bst3' => $request->bst3,
            'bst4' => $request->bst4,
            'bst5' => $request->bst5,
            'avg_bst' => $request->avg_bst,
            'ect1' => $request->ect1,
            'ect2' => $request->ect2,
            'ect3' => $request->ect3,
            'ect4' => $request->ect4,
            'ect5' => $request->ect5,
            'avg_ect' => $request->avg_ect,
            'bct1' => $request->bct1,
            'bct2' => $request->bct2,
            'bct3' => $request->bct3,
            'bct4' => $request->bct4,
            'bct5' => $request->bct5,
            'avg_bct' => $request->avg_bct,
            'created_by' => $request->createdBy,
        ]);

        return redirect('admin/qc')->with('success', "COA berhasil disimpan");
    }

    public function edit($id) {

        $data = QcModel::where('testqc.id', '=', $id)
            ->leftJoin('opi_m', 'opi_id', '=', 'opi_m.id')
            ->leftJoin('mc', 'opi_m.mc_id', '=', 'mc.id')
            ->leftJoin('box', 'mc.box_id', '=', 'box.id')
            ->select('testqc.*','opi_m.NoOPI as noopi', 'mc.flute', 'mc.gramSheetBoxKontrak2 as gram', 'mc.joint', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'mc.panjangSheetBox', 'mc.lebarSheetBox')
            ->first();

        // dd($data);
        
        $opi = Opi_M::opi2()
            ->limit(5)
            ->where('periode', 'LIKE', '2024')
            ->get();

        return view('admin.qc.edit', compact('opi'), [
            'data' => $data,
        ]);
    }

    public function update($id, Request $request) {
        $update = QcModel::where('id', '=', $id)->first();

        $update->tanggal_analisa = $request->tgl_analisa;
        $update->opi_id = $request->opiid;
        $update->mc = $request->mc;
        $update->cust = $request->cust;
        $update->item = $request->item;
        $update->kwalitas = $request->kualitas;
        $update->no_po = $request->po_cust;
        $update->no_batch = $request->nobatch;
        $update->jumlah_kirim = $request->jumlah_kirim;
        $update->berat1 = $request->berat1;
        $update->berat2 = $request->berat2;
        $update->berat3 = $request->berat3;
        $update->berat4 = $request->berat4;
        $update->berat5 = $request->berat5;
        $update->avg_berat = $request->avg_berat;
        $update->bst1 = $request->bst1;
        $update->bst2 = $request->bst2;
        $update->bst3 = $request->bst3;
        $update->bst4 = $request->bst4;
        $update->bst5 = $request->bst5;
        $update->avg_bst = $request->avg_bst;
        $update->ect1 = $request->ect1;
        $update->ect2 = $request->ect2;
        $update->ect3 = $request->ect3;
        $update->ect4 = $request->ect4;
        $update->ect5 = $request->ect5;
        $update->avg_ect = $request->avg_ect;
        $update->bct1 = $request->bct1;
        $update->bct2 = $request->bct2;
        $update->bct3 = $request->bct3;
        $update->bct4 = $request->bct4;
        $update->bct5 = $request->bct5;
        $update->avg_bct = $request->avg_bct;
        $update->updated_by = $request->updatedBy;

        $update->save();

        return redirect('admin/qc')->with('success', "COA sudah terupdate!!");
    }

    public function print($id) {

        $data = QcModel::where('testqc.id', '=', $id)
        ->leftJoin('opi_m', 'opi_id', '=', 'opi_m.id')
        ->leftJoin('mc', 'opi_m.mc_id', '=', 'mc.id')
        ->leftJoin('box', 'mc.box_id', '=', 'box.id')
        ->select('testqc.*','opi_m.NoOPI as noopi', 'mc.flute', 'mc.gramSheetBoxKontrak2 as gram', 'mc.joint', 'box.panjangDalamBox as panjang', 'box.lebarDalamBox as lebar', 'box.tinggiDalamBox as tinggi', 'mc.panjangSheetBox', 'mc.lebarSheetBox')
        ->first();

        return view('admin.qc.print', compact('data'));

    }

    public function delete($id) {
        $data = QcModel::find($id);

        $data->delete();

        return redirect('admin/qc')->with("success", "COA berhasil dihapus!!");
    }
}
