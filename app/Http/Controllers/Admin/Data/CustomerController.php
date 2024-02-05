<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DetBBM;
use App\Models\dumrolModel;
use App\Models\Mastercard;
use App\Models\TCustModel;
use App\Models\EkspedisiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

    class CustomerController extends Controller
{
    public function syncronize()
    {
        $cust = DB::connection('firebird')->table('TCustomer')->orderBy('Kode', 'asc')
            ->get();
        $count = count($cust);

        $exp = DB::connection('firebird')->table('TSupplier')->where('Kode', 'LIKE', 'J%')->get();
        $cexp = count($exp);

        EkspedisiModel::truncate();
        TCustModel::truncate(); 

        foreach ($exp as $data) {
            EkspedisiModel::create([
                'kode' => trim($data->Kode),
                'expedisi' => trim($data->Nama)
            ]);
        }
        
        foreach ($cust as $cust) {
             TCustModel::create([
                'kode' => trim($cust->Kode),
                'nama' => trim($cust->Nama),
                'npwp' => trim($cust->NPWP),
                'alamat1' => trim($cust->AlamatKantor),
                'alamat2' => trim($cust->AlamatKirim),
                'umur' => trim($cust->WAKTUBAYAR),
                'lkredit' => trim($cust->Plafond2),
                'telp' => trim($cust->TelpKantor),
                'kontak' => trim($cust->PIC)
             ]);
            
        }
        
        return redirect('admin/data/cust')->with('success', 'Syncronize Data Selesai!!'); 
    }
    
    public function index()
    {
        $cust = Customer::get();

        // phpinfo();
        
        return view('admin.data.customer', compact('cust'));
    }
    
    public function getBBM(Request $request) {
        
        // dd($request->all());
        $returprod = DB::connection('firebird3')->table('TDetReturProd')
        ->leftJoin('TReturProd', 'TDetReturProd.NoBukti', '=', 'TReturProd.NoBukti')
        ->whereBetween('TReturProd.TglRetur', [$request->mulai, $request->selesai])->get();
        
        foreach ($returprod as $retur) {
            $detbbm = DetBBM::where('NOBBK','=', $retur->NoBBK)
            ->where('KodeBrg', '=', $retur->KodeBrg)
            ->first();
            
            $detbbm->BrtRew = $retur->QtyS;
            $detbbm->NOBBK = null;
            $detbbm->save();
            
        }
        
        return redirect('admin/data/stokroll')->with('success', 'Recall Berhasil!!');
    }
    
    public function getStok(){

        $detbbm = DB::connection('firebird3')->table('TDet2BBM')
        ->leftJoin('TBBMConv', 'NomerBBM', '=', 'TBBMConv.NoBukti')
        ->leftJoin('TBarang', 'TDet2BBM.KodeBrg', '=', 'TBarang.KodeBrg')
        ->leftJoin('TJenisProd', 'TBarang.JenisProd', '=', 'TJenisProd.Kode')
        ->leftJoin('TKelompokBrg', 'TBarang.KdKelBrg', '=', 'TKelompokBrg.KodeKel')
        ->where('NOBBK', '=', null)->get();

        // dd($detbbm);

        dumrolModel::truncate();

        foreach ($detbbm as $key) {
            dumrolModel::create([
                'nomer' => trim($key->NoBukti),
                'tanggal' => trim($key->TglMasuk),
                'kode' => trim($key->KodeBrg),
                'barang' => trim($key->NamaBrg),
                'ukuran' => trim($key->NamaKel),
                'kwalitas' => trim($key->JenisProduksi),
                'terima' => trim($key->BrtRew),
                'terima2' => 1,
                'noroll' => trim($key->KodeRoll),
                'noroll2' => trim($key->KDROLLSUP),
            ]);

            // $data[] = $nestedData; 
        }

        // dd($detbbm);
        
        return view('admin.data.stokRoll', compact('detbbm'));
    }

    public function single_cust($id){
        $cust = DB::connection('firebird')->table('TCustomer')
            ->where('Kode', '=', $id)
            ->first();

        echo (json_encode($cust));
    }

    public function alamat_cust(){
        $cust = DB::connection('firebird')->table('TCustomer')->get();
        
        return view('admin.data.alamat', compact('cust'));
    }

    public function print_cust(Request $request){
        $data = array();
        $id = array_merge($request->cust_id);

        for ($i=0; $i < count($id); $i++) { 
            $cust = DB::connection('firebird')->table('TCustomer')
                    ->where('Kode', '=', $id[$i])
                    ->first();
            $nestedData['id'] = trim($cust->Kode, " ");
            $nestedData['nama'] = trim($cust->Nama, " ");
            $nestedData['alamat'] = $cust->AlamatAcc;
            $nestedData['pic'] = $cust->PIC;
            $nestedData['telp'] = $cust->TelpKirim;

            $data[] = $nestedData;
        }

        return view('admin.data.print_alamat', compact('data'));
    }
}
