<?php

use App\Http\Controllers\Admin\Accounting\KontrakAccController;
use App\Http\Controllers\Admin\Data\CustomerController;
use App\Http\Controllers\Admin\PPIC\OpiPPICController;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Opi_M;
use App\Models\RealisasiKirim;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    $periode = date("Y-m");

    $dt = RealisasiKirim::select(DB::raw('SUM(kg_kirim) as kirim'))
        ->where('tanggal_kirim', 'LIKE', '%'.$periode.'%')
        ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
        ->first();

        // dd($dt->kirim);

        $kirim = RealisasiKirim::select('realisasi_kirim.tanggal_kirim', 'realisasi_kirim.id', DB::raw('DATE_FORMAT(realisasi_kirim.tanggal_kirim, "%Y-%m") as periode'))
            ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->orderBy('periode', 'desc')
            ->groupBy('periode')
            ->take(12)
            ->get();

            $all_periode = [];

            foreach ($kirim as $key) {
                $all_periode[] = $key->periode;
            }

        $realisasi = $dt->kirim;
        
        $opi = Opi_M::where('nama', 'NOT LIKE', '%CANCEL%')
            ->where('tglKirimDt', 'LIKE', '%'.$periode.'%')
            ->leftJoin('mc', 'mc_id', '=', 'mc.id')
            ->get();    

        $tonase = 0;    
        foreach ($opi as $key) {
            $order = $key->jumlahOrder * $key->gramSheetBoxKontrak;
            $tonase = $tonase + $order ;
        }
    
    $data = RealisasiKirim::select('id', DB::raw('SUM(kg_kirim) as kirim, DATE_FORMAT(realisasi_kirim.tanggal_kirim, "%Y-%m") as periode'))
    // ->where('tanggal_kirim', 'LIKE', '%'.$periode.'%')
    ->orderBy('periode', 'Desc')
    ->groupBy('periode')
    ->take(12)
    ->get();

    // dd($data);

    $kontrak = Kontrak_M::where('tglKontrak', 'LIKE', '%'.$periode.'%')
            ->get();
    $jumlah_kontrak = count($kontrak);
    return view('admin.index', compact('jumlah_kontrak','tonase','realisasi', 'all_periode','data'));
})->middleware(['auth'])->name('admin');


Route::middleware(['auth'])->group(function (){
    
    //Satuan
    Route::get('/admin/satuans', 'SatuansController@index')->name('satuan');
    Route::get('/admin/satuans/create', 'SatuansController@create')->name('satuan.create');
    Route::post('/admin/satuans/store', 'SatuansController@store')->name('satuan.store');
    Route::get('/admin/satuans/edit/{id}', 'SatuansController@edit');
    Route::put('/admin/satuans/update/{id}', 'SatuansController@update');
    Route::get('/admin/satuans/show/{id}', 'SatuansController@show');
    Route::get('/admin/satuans/delete/{id}', 'SatuansController@updateDeleted');
    
    //Divisi
    Route::get('/admin/divisi', 'DivisiController@index')->name('divisi');
    Route::get('/admin/divisi/create', 'DivisiController@create')->name('divisi.create');
    Route::post('/admin/divisi/store', 'DivisiController@store')->name('divisi.store');
    Route::get('/admin/divisi/show/{id}', 'DivisiController@show');
    Route::get('/admin/divisi/edit/{id}', 'DivisiController@edit');
    Route::put('/admin/divisi/update/{id}', 'DivisiController@update')->name('divisi.update');
    Route::get('/admin/divisi/delete/{id}', 'DivisiController@updateDeleted');
    
    //Flute
    Route::get('/admin/flute', 'FluteController@index')->name('flute');
    Route::get('/admin/flute/create', 'FluteController@create')->name('flute.create');
    Route::post('/admin/flute/store', 'FluteController@store')->name('flute.store');
    Route::get('/admin/flute/show/{id}', 'FluteController@show');
    Route::get('/admin/flute/edit/{id}', 'FluteController@edit');
    Route::put('/admin/flute/update/{id}', 'FluteController@update');
    Route::get('/admin/flute/delete/{id}', 'FluteController@updateDeleted');

    //Jenis Downtime
    Route::get('/admin/jenisdowntime', 'JenisDowntimeController@index')->name('jenisdowntime');
    Route::get('/admin/jenisdowntime/create', 'JenisDowntimeController@create')->name('jenisdowntime.create');
    Route::post('/admin/jenisdowntime/store', 'JenisDowntimeController@store')->name('jenisdowntime.store');
    Route::get('/admin/jenisdowntime/show/{id}', 'JenisDowntimeController@show');
    Route::get('/admin/jenisdowntime/edit/{id}', 'JenisDowntimeController@edit');
    Route::put('/admin/jenisdowntime/update/{id}', 'JenisDowntimeController@update');
    Route::get('/admin/jenisdowntime/delete/{id}', 'JenisDowntimeController@updateDeleted');
    
    //Mata Uang
    Route::get('/admin/matauang', 'MataUangController@index')->name('matauang');
    Route::get('/admin/matauang/create', 'MataUangController@create')->name('matauang.create');
    Route::post('/admin/matauang/store', 'MataUangController@store')->name('matauang.store');
    Route::get('/admin/matauang/show/{id}', 'MataUangController@show');
    Route::get('/admin/matauang/edit/{id}', 'MataUangController@edit');
    Route::put('/admin/matauang/update/{id}', 'MataUangController@update');
    Route::get('/admin/matauang/delete/{id}', 'MataUangController@updateDeleted');
    
    //Joint
    Route::get('/admin/joint', 'JointController@index')->name('joint');
    Route::get('/admin/joint/create', 'JointController@create')->name('joint.create');
    Route::post('/admin/joint/store', 'JointController@store')->name('joint.store');
    Route::get('/admin/joint/show/{id}', 'JointController@show');
    Route::get('/admin/joint/edit/{id}', 'JointController@edit');
    Route::put('/admin/joint/update/{id}', 'JointController@update');
    Route::get('/admin/joint/delete/{id}', 'JointController@updateDeleted');
    
    //Sheet
    Route::get('/admin/sheet', 'SheetController@index')->name('sheet');
    Route::get('/admin/sheet/create', 'SheetController@create')->name('sheet.create');
    Route::post('/admin/sheet/store', 'SheetController@store')->name('sheet.store');
    Route::get('/admin/sheet/show/{id}', 'SheetController@show');
    Route::get('/admin/sheet/edit/{id}', 'SheetController@edit');
    Route::put('/admin/sheet/update/{id}', 'SheetController@update');
    Route::get('/admin/sheet/delete/{id}', 'SheetController@updateDeleted');
    
    //Box
    Route::get('/admin/box', 'BoxController@index')->name('box');
    Route::get('/admin/box/create', 'BoxController@create')->name('box.create');
    Route::post('/admin/box/store', 'BoxController@store')->name('box.store');
    Route::get('/admin/box/show/{id}', 'BoxController@show');
    Route::get('/admin/box/edit/{id}', 'BoxController@edit');
    Route::put('/admin/box/update/{id}', 'BoxController@update')->name('box.update');
    Route::get('/admin/box/delete/{id}', 'BoxController@updateDeleted');
    
    //Koli
    Route::get('/admin/koli', 'KoliController@index')->name('koli');
    Route::get('/admin/koli/create', 'KoliController@create')->name('koli.create');
    Route::post('/admin/koli/store', 'KoliController@store')->name('koli.store');
    Route::get('/admin/koli/show/{id}', 'KoliController@show');
    Route::get('/admin/koli/edit/{id}', 'KoliController@edit');
    Route::put('/admin/koli/update/{id}', 'KoliController@update');
    Route::get('/admin/koli/delete/{id}', 'KoliController@updateDeleted');
    
    //Substance
    Route::get('/admin/substance', 'SubstanceController@index')->name('substance');
    Route::get('/admin/substance/create', 'SubstanceController@create')->name('substance.create');
    Route::post('/admin/substance/store', 'SubstanceController@store')->name('substance.store');
    Route::get('/admin/substance/show/{id}', 'SubstanceController@show');
    Route::get('/admin/substance/edit/{id}', 'SubstanceController@edit');
    Route::put('/admin/substance/update/{id}', 'SubstanceController@update');
    Route::get('/admin/substance/delete/{id}', 'SubstanceController@updateDeleted');
    
    //Jenis Gram
    Route::get('/admin/jenisgram', 'JenisGramController@index')->name('jenisgram');
    Route::get('/admin/jenisgram/create', 'JenisGramController@create')->name('jenisgram.create');
    Route::post('/admin/jenisgram/store', 'JenisGramController@store')->name('jenisgram.store');
    Route::get('/admin/jenisgram/show/{id}', 'JenisGramController@show');
    Route::get('/admin/jenisgram/edit/{id}', 'JenisGramController@edit');
    Route::put('/admin/jenisgram/update/{id}', 'JenisGramController@update');
    Route::get('/admin/jenisgram/delete/{id}', 'JenisGramController@updateDeleted');
    
    
    //Tipe Box
    Route::get('/admin/boxtype', 'BoxTypeController@index')->name('boxtype');
    Route::get('/admin/boxtype/create', 'BoxTypeController@create')->name('boxtype.create');
    Route::post('/admin/boxtype/store', 'BoxTypeController@store')->name('boxtype.store');
    Route::get('/admin/boxtype/show/{id}', 'BoxTypeController@show');
    Route::get('/admin/boxtype/edit/{id}', 'BoxTypeController@edit');
    Route::put('/admin/boxtype/update/{id}', 'BoxTypeController@update');
    Route::get('/admin/boxtype/delete/{id}', 'BoxTypeController@updateDeleted');
    
    //Warna
    Route::get('/admin/warna', 'WarnaController@index')->name('warna');
    Route::get('/admin/warna/create', 'WarnaController@create')->name('warna.create');
    Route::post('/admin/warna/store', 'WarnaController@store')->name('warna.store');
    Route::get('/admin/warna/show/{id}', 'WarnaController@show');
    Route::get('/admin/warna/edit/{id}', 'WarnaController@edit');
    Route::put('/admin/warna/update/{id}', 'WarnaController@update');
    Route::get('/admin/warna/delete/{id}', 'WarnaController@updateDeleted');
    
    //Warna Combine
    Route::get('/admin/colorcombine', 'ColorCombineController@index')->name('colorcombine');
    Route::get('/admin/colorcombine/create', 'ColorCombineController@create')->name('colorcombine.create');
    Route::post('/admin/colorcombine/store', 'ColorCombineController@store')->name('colorcombine.store');
    
    
    //Sales
    Route::get('/admin/sales', 'SalesController@index')->name('sales');
    Route::get('/admin/sales/create', 'SalesController@create')->name('sales.create');
    Route::post('/admin/sales/store', 'SalesController@store')->name('sales.store');
    Route::get('/admin/sales/show/{id}', 'SalesController@show');
    Route::get('/admin/sales/edit/{id}', 'SalesController@edit');
    Route::put('/admin/sales/update/{id}', 'SalesController@update');
    Route::get('/admin/sales/delete/{id}', 'SalesController@updateDeleted');
    
    //Palet Item
    Route::get('/admin/palet', 'PaletController@index')->name('palet');
    Route::get('/admin/palet/create', 'PaletController@create')->name('palet.create');
    Route::post('/admin/palet/store', 'PaletController@store')->name('palet.store');
    Route::get('/admin/palet/show/{id}', 'PaletController@show');
    Route::get('/admin/palet/edit/{id}', 'PaletController@edit');
    Route::put('/admin/palet/update/{id}', 'PaletController@update');
    Route::get('/admin/palet/delete/{id}', 'PaletController@updateDeleted');
    // Route::post('/admin/palet/getPalet/{id}', 'PaletController@updateDeleted')->name('palet.getPalet');
    
    //Surat Jalan
    Route::get('/admin/sj_palet', 'SJ_Palet_DController@index')->name('sj_palet');
    Route::get('/admin/sj_palet/create', 'SJ_Palet_DController@create')->name('sj_palet.create');
    Route::post('/admin/sj_palet/store', 'SJ_Palet_DController@store')->name('sj_palet.store');
    Route::get('/admin/sj_palet/show/{sj_palet_m_id}', 'SJ_Palet_DController@show');
    Route::get('/admin/sj_palet/edit/{id}', 'SJ_Palet_DController@edit');
    Route::put('/admin/sj_palet/update/{id}', 'SJ_Palet_DController@update');
    Route::get('/admin/sj_palet/delete/{id}', 'SJ_Palet_DController@updateDeleted');
    Route::get('/admin/sj_palet/pdf/{sj_palet_m_id}', 'SJ_Palet_DController@pdfprint');
    
    //Supplier
    Route::get('/admin/supplier', 'SuppliersController@index')->name('supplier');
    Route::get('/admin/supplier/show/{id}', 'SuppliersController@show')->name('supplier.show');
    
    //Barang
    Route::get('/admin/barang', 'BarangController@index')->name('barang');
    
    //Mastercard
    Route::name('mastercard.')->prefix('mastercard')->group(function() {
        Route::get('/json', 'MastercardController@json')->name('json');
        Route::get('/get_data', 'MastercardController@get_mc_all')->name('get_data');
        Route::get('/', 'MastercardController@indexb1')->middleware(['auth'])->name('b1');
        Route::get('/admin/mastercard/dc', 'MastercardController@indexdc')->middleware(['auth'])->name('dc');
        Route::get('/admin/mastercard/create', 'MastercardController@create')->name('create');
        Route::post('/admin/mastercard/store', 'MastercardController@store')->name('store');
        Route::get('/admin/mastercard/edit/{id}', 'MastercardController@edit')->name('edit');
        Route::get('/admin/mastercard/revisi/{id}', 'MastercardController@revisi')->name('revisi');
        Route::post('/admin/mastercard/prosesRevisi/{id}', 'MastercardController@saveRevisi')->name('saveRevisi');
        Route::post('/admin/mastercard/update', 'MastercardController@update')->name('update');
        Route::get('/admin/mastercard/pdf/{id}', 'MastercardController@pdfprint')->name('pdfb1');
    });

    


    //Kontrak
    Route::post('kontrakjson', 'Kontrak_DController@json')->name('kontrak.json');
    Route::get('/admin/kontrak', 'Kontrak_DController@index')->middleware(['auth'])->name('kontrak');
    // Route::get('/admin/kontrak/json', 'Kontrak_DController@json')->name('kontrak.json');
    Route::get('/admin/kontrak/create', 'Kontrak_DController@create')->name('kontrak.create');
    Route::post('/admin/kontrak/store', 'Kontrak_DController@store')->name('kontrak.store');
    Route::post('/admin/kontrak/store_realisasi', 'Kontrak_DController@store_realisasi')->name('kontrak.store_realisasi');
    Route::get('/admin/kontrak/edit/{id}', 'Kontrak_DController@edit')->name('kontrak.edit');
    Route::get('/admin/kontrak/realisasi/{id}', 'Kontrak_DController@add_realisasi')->name('kontrak.realisasi');
    Route::get('/admin/kontrak/dt/{id}', 'Kontrak_DController@add_dt')->name('kontrak.dt');
    Route::post('/admin/kontrak/store_dt', 'Kontrak_DController@store_dt')->name('kontrak.store_dt');
    Route::put('/admin/kontrak/realisasi/edit{id}', 'Kontrak_DController@edit_realisasi')->name('kontrak.edit_kirim');
    Route::put('/admin/kontrak/update/{id}', 'Kontrak_DController@update')->name('kontrak.update');
    Route::get('/admin/kontrak/pdf/{id}', 'Kontrak_DController@pdfprint')->name('kontrak.pdfb1');
    Route::get('/admin/kontrak/cancel/{id}', 'Kontrak_DController@cancel_kontrak')->name('kontrak.cancel');
    Route::get('/admin/kontrak/open/{id}', 'Kontrak_DController@open_kontrak')->name('kontrak.open');
    Route::get('/admin/kontrak/recall/{id}', 'Kontrak_DController@recall')->name('kontrak.recall');
    Route::get('/admin/kontrak/oskontrak', 'Kontrak_DController@empty_opi')->name('kontrak.kosong');

    //Delivery Time
    Route::get('/admin/dt', 'DTController@index')->middleware(['auth'])->name('dt');
    Route::get('/admin/dt/edit/{id}', 'DTController@edit')->name('dt.edit');
    Route::put('/admin/dt/update/{id}', 'DTController@update')->name('dt.update');
    Route::get('/admin/dt/approve/{id}', 'DTController@approve')->name('dt.approve');
    Route::get('/admin/dt/delete/{id}', 'DTController@destroy')->name('dt.destroy');

    //OPI
    Route::get('/admin/opi', 'OpiController@index')->middleware(['auth'])->name('opi');
    Route::get('/admin/opi/create', 'OpiController@create')->name('opi.create');
    Route::post('opijson', 'OpiController@json')->name('opi.json');
    Route::post('/admin/opi/store', 'OpiController@store')->name('opi.store');
    Route::get('/admin/opi/edit/{id}', 'OpiController@edit')->name('opi.edit');
    Route::put('/admin/opi/update/{id}', 'OpiController@update')->name('opi.update');
    Route::get('/admin/opi/print/{id}', 'OpiController@print')->name('opi.print');
    Route::get('/admin/opi/cancel/{id}', 'OpiController@cancel')->name('opi.cancel');
    Route::get('/admin/opi/closed/{id}', 'OpiController@closed')->name('opi.closed');
    Route::get('/admin/opi/single/{id}', 'OpiController@single')->name('opi.single');

    //PLAN
    Route::get('/admin/plan/corr', 'CorrController@index')->middleware(['auth'])->name('indexcorr');
    Route::get('/admin/plan/corrm', 'CorrController@corrm')->middleware(['auth'])->name('corrm');
    Route::get('/admin/plan/corrmhasil', 'CorrController@corrm_hasil')->middleware(['auth'])->name('corrm.hasil');
    // Route::get('/admin/plan/corr/create', 'CorrController@create')->name('corr.create');
    Route::get('/admin/plan/corr/newcreate', 'CorrController@create2')->name('corr.create2');
    Route::post('/admin/plan/corr/json', 'CorrController@json')->name('corr.json');
    // Route::post('/admin/plan/corr/store', 'CorrController@store')->name('corr.store');
    Route::post('/admin/plan/corr/newstore', 'CorrController@new_store')->name('corr.newstore');
    // Route::get('/admin/plan/corr/edit/{id}', 'CorrController@edit')->name('corr.edit');
    Route::get('/admin/plan/corr/newedit/{id}', 'CorrController@new_edit')->name('corr.edit');
    Route::put('/admin/plan/corr/newupdate/{id}', 'CorrController@new_update')->name('corr.newupdate');
    // Route::put('/admin/plan/corr/update/{id}', 'CorrController@update')->name('corr.update');
    Route::get('/admin/plan/corr/print/{id}', 'CorrController@corr_pdf')->name('corr.print');
    Route::get('/admin/plan/corr/hapus/{id}', 'CorrController@delete')->name('corr.delete');

    
    Route::get('/admin/plan/conv', 'ConvController@index')->middleware(['auth'])->name('conv');
    Route::get('/admin/plan/conv/flexoacreate', 'ConvController@createFlexoA')->middleware(['auth'])->name('flexoa.create');
    Route::post('/admin/plan/conv/storenonprint', 'ConvController@storeNonPrinting')->middleware(['auth'])->name('conv.storenonprint');
    Route::get('/admin/plan/conv/create', 'ConvController@create')->name('conv.create');
    Route::get('/admin/plan/conv/createnonprinting', 'ConvController@create_non_printing')->name('conv.create_non_printing');
    Route::get('/admin/plan/conv/convd', 'ConvController@convd')->name('convd');
    Route::get('/admin/plan/conv/convm', 'ConvController@convm')->name('convm');
    Route::get('/admin/plan/conv/json', 'ConvController@json')->name('conv.json');
    Route::post('/admin/plan/conv/store', 'ConvController@store')->name('conv.store');
    Route::get('/admin/plan/conv/edit/{id}', 'ConvController@edit')->name('conv.edit');
    Route::put('/admin/plan/conv/update/{id}', 'ConvController@update')->name('conv.update');
    Route::get('/admin/plan/conv/print/{id}', 'ConvController@conv_pdf')->name('conv.print');

    //Hasil Produksi
    Route::get('/admin/plan/control', 'CorrController@control')->middleware(['auth'])->name('hasilcorr');
    Route::get('/admin/produksi/datacorr', 'HasilProduksiController@plan_corr')->middleware(['auth'])->name('plan_corr');
    Route::get('/admin/produksi/hasilcorr', 'HasilProduksiController@index_corr')->middleware(['auth'])->name('index_corr');
    Route::get('/admin/produksi/convd_flexo', 'HasilProduksiController@convd_flexo')->middleware(['auth'])->name('convd.flexo');
    Route::get('/admin/produksi/hasilconv', 'HasilProduksiController@index_conv')->middleware(['auth'])->name('conv.hasilflexo');
    Route::get('/admin/produksi/inputhasilcorr/{id}', 'HasilProduksiController@index_detail_corr')->middleware(['auth'])->name('hasilcorr.edit');
    Route::get('/admin/produksi/inputhasilconv/{id}', 'HasilProduksiController@index_detail_conv')->middleware(['auth'])->name('hasilconv.edit');
    // Route::get('/admin/produksi/hasilcorr/edit/{id}', 'HasilProduksiController@input_hasil')->name('hasilcorr.edit');
    // Route::get('/admin/produksi/hasilconv/edit/{id}', 'HasilProduksiController@input_hasil_conv')->name('hasilconv.edit');
    Route::post('/admin/produksi/hasil', 'HasilProduksiController@hasil_produksi')->middleware(['auth'])->name('hasil_produksi');
    Route::get('/admin/plan/detail/{id}', 'CorrController@show')->middleware(['auth'])->name('detail');

    //Produksi
    Route::get('/admin/produksi/index',     'LaporanProduksiController@index')->name('lap.produksi');
    Route::get('/admin/produksi/filter',          'LaporanProduksiController@get_filter')->name('filter');

    Route::get('/admin/roll',                       'RollController@index')->name('roll');
    Route::get('/admin/roll/bbm',                   'RollController@indexBbm')->name('roll.bbm');
    Route::get('/admin/roll/bbm/create',            'RollController@bbmRoll')->name('roll.createbbm');
    Route::post('/admin/roll/bbm/store',            'RollController@store')->name('roll.store');
    Route::get('/admin/roll/bbk/{id}',              'RollController@bbk')->name('roll.bbk');
    Route::put('/admin/roll/prosesbbk/{id}',        'RollController@prosesBbk')->name('roll.prosesbbk');
    Route::get('/admin/roll/returbbk/{id}',         'RollController@returBbk')->name('roll.returbbk');
    Route::put('/admin/roll/preturbbk/{id}',        'RollController@prosesRetur')->name('roll.preturbbk');
    Route::get('/admin/roll/edit/{id}',             'RollController@edit')->name('roll.edit');
    Route::put('/admin/roll/update/{id}',           'RollController@update')->name('roll.update');
    Route::put('/admin/roll/hapus/{id}',            'RollController@delete')->name('roll.delete');

    // PPIC

        // OPI

        Route::get('/admin/ppic/opi',  [OpiPPICController::class, 'index'])->name('ppic.opi');
        Route::get('admin/ppic/opidata', [OpiPPICController::class, 'get_opibyperiode'])->name('ppic.opi.bydate');
        Route::get('admin/ppic/opi_approve', [OpiPPICController::class, 'approve_opi'])->name('ppic.opi.approve');
        Route::get('admin/ppic/opi_approve_proses/{id}', [OpiPPICController::class, 'proses_approve'])->name('ppic.opi.proses_approve');

    // Accounting
        // 
        
        Route::get('admin/acc', [KontrakAccController::class, 'index'])->name('acc.kontrak.index');
        Route::get('admin/acc/kontrak', [KontrakAccController::class, 'json'])->name('acc.kontrak.json');

        
    // Data
        Route::get('admin/data/sync', [CustomerController::class, 'syncronize'])->name('data.sync');
        Route::get('admin/data/cust', [CustomerController::class, 'index'])->name('data.cust');
        Route::get('admin/data/detbbm', [CustomerController::class, 'getBBM'])->name('data.detbbm');
        Route::get('admin/data/stokroll', [CustomerController::class, 'getStok'])->name('data.stok');
        Route::get('admin/data/alamat', [CustomerController::class, 'alamat_cust'])->name('data.alamat');
        Route::get('admin/cust/single/{id}', [CustomerController::class, 'single_cust'])->name('data.custsingle');
        Route::post('admin/cust/print', [CustomerController::class, 'print_cust'])->name('cust.print');

        Route::get('admin/periode', function () {
            $kirim = RealisasiKirim::select('realisasi_kirim.tanggal_kirim', 'realisasi_kirim.id', DB::raw('DATE_FORMAT(realisasi_kirim.tanggal_kirim, "%Y-%m") as periode'))
            ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
            ->orderBy('realisasi_kirim.id', 'desc')
            ->groupBy('periode')
            // ->take(10)
            ->get();

            $all_periode = [];

            foreach ($kirim as $key) {

                $all_periode[] = $key->periode;
            }

            return response()->json($all_periode);

        })->name('periode');
    
    // QC
        Route::get('admin/qc', 'QcController@index')->name('qc.index');
        Route::get('admin/qc/create', 'QcController@create')->name('qc.create');
        Route::post('admin/qc/store', 'QcController@store')->name('qc.store');
        Route::get('admin/qc/edit/{id}', 'QcController@edit')->name('qc.edit');
        Route::put('admin/qc/update/{id}', 'QcController@update')->name('qc.update');
        Route::get('admin/qc/print/{id}', 'QcController@print')->name('qc.print');
        Route::get('admin/qc/delete/{id}', 'QcController@delete')->name('qc.delete');
}); 



require __DIR__ . '/auth.php';
