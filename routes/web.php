<?php

use App\Exports\OpiExport;
use App\Exports\VendorTTExport;
use App\Http\Controllers\Admin\Accounting\FinanceController;
use App\Http\Controllers\Admin\Accounting\KontrakAccController;
use App\Http\Controllers\Admin\Converting\ConvertingController;
use App\Http\Controllers\Admin\Data\BarangTeknikController;
use App\Http\Controllers\Admin\Data\CustomerController;
use App\Http\Controllers\Admin\Data\BbmRollController;
use App\Http\Controllers\Admin\HRD\StationaryController;
use App\Http\Controllers\Admin\Navbar\NavbarController;
use App\Http\Controllers\Admin\PPIC\OpiPPICController;
use App\Http\Controllers\AlokasiKaretController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Kontrak_DController;
use App\Http\Controllers\Marketing\FormMc;
use App\Http\Controllers\Marketing\FormPermintaan;
use App\Http\Controllers\Marketing\MarektingOrder;
use App\Http\Controllers\MastercardController;
use App\Http\Controllers\OpiController;
use App\Http\Controllers\CorrugatedController;
use App\Http\Controllers\ForecastCustController;
use App\Http\Controllers\PaletController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SJ_Palet_DController;
use App\Http\Controllers\Stellar\BP\BbmController;
use App\Models\Accounting\VendorTT;
use App\Models\Accounting\VendorTTDet;
use App\Models\Kontrak_D;
use App\Models\Kontrak_M;
use App\Models\Opi_M;
use App\Models\RealisasiKirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Row;

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

// Test route for OPI without auth middleware
Route::get('/test-opi-data', 'OpiController@jsonPaginated');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    $periode = date("Y-m");

    $dt = RealisasiKirim::select(DB::raw('SUM(kg_kirim) as kirim'))
        ->where('tanggal_kirim', 'LIKE', '%'.$periode.'%')
        ->leftJoin('kontrak_m', 'kontrak_m_id', '=', 'kontrak_m.id')
        ->first();

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

    $kontrak_open = Kontrak_M::where('status', '2')->get();

    $kontrak = Kontrak_M::where('tglKontrak', 'LIKE', '%'.$periode.'%')
            ->get();
    $jumlah_kontrak = count($kontrak);
    return view('admin.index', compact('jumlah_kontrak','tonase','realisasi', 'all_periode','data', 'kontrak_open'));
})->middleware(['auth'])->name('admin');


Route::middleware(['auth'])->group(function (){
    
    // Profile Management Routes
    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::put('/profile/update', 'ProfileController@updateProfile')->name('profile.update');
    Route::get('/profile/change-password', 'ProfileController@showChangePasswordForm')->name('profile.change-password');
    Route::post('/profile/change-password', 'ProfileController@updatePassword')->name('profile.update-password');
    Route::get('/profile/password-requirements', 'ProfileController@getPasswordRequirements')->name('profile.password-requirements');
    
    // API routes for BBK Roll functionality
    Route::get('/api/inventories/available', [App\Http\Controllers\InventoryController::class, 'getAvailableInventories'])->name('api.inventories.available');
    Route::get('/api/inventories/paginated', [App\Http\Controllers\InventoryController::class, 'getPaginatedInventory'])->name('inventory.paginated');
    Route::get('/api/inventories/{id}', [App\Http\Controllers\InventoryController::class, 'getInventoryDetails'])->name('api.inventories.details');
    
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
    Route::get('converting/getsheet', [ConvertingController::class, 'get_sheet'])->name('getsheet');
    Route::get('converting/sheet', [ConvertingController::class, 'index_sheet'])->name('sheet');
    Route::get('/admin/sheet/create', [ConvertingController::class, 'create'])->name('sheet.create');
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
    Route::get('/admin/sycn_sj', 'PaletController@sync_sj')->name('sync_sj');
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
    Route::get('/export/sjpalet', [SJ_Palet_DController::class, 'export_sjpalet_excel'])->name('export.sjpalet');
    
    //Supplier
    Route::get('/admin/supplier', 'SuppliersController@index')->name('supplier');
    Route::get('/admin/supplier/show/{id}', 'SuppliersController@show')->name('supplier.show');
    
    //Barang Jadi
    Route::get('/admin/barang', 'BarangController@index')->name('barang');
    Route::get('/admin/barang/new', 'BarangController@indexnew')->name('barang.indexnew');
    Route::get('/admin/fg/returjual', 'BarangController@returjual')->name('barang.retur');
    Route::get('/admin/fg/returjual/create', 'BarangController@create_retur')->name('barang.retur.create');
    Route::post('/admin/fg/returjual/store', 'BarangController@store_retur')->name('barang.retur.store');
    Route::get('/admin/fg/returjual/{nobukti}/edit', 'BarangController@edit_retur')->name('barang.retur.edit');
    Route::put('/admin/fg/returjual/{nobukti}', 'BarangController@update_retur')->name('barang.retur.update');
    Route::get('/admin/fg/returjual/{nobukti}', 'BarangController@show_retur')->name('barang.retur.show');
    Route::get('/returjual/{tanggal}', 'BarangController@get_kode_retur')->name('barang.retur.get_kode');
    Route::get('/get_sj/{no_sj}', 'BarangController@get_sj')->name('barang.get_sj');
    Route::get('/admin/barang/create', 'BarangController@create')->name('barang.create');
    Route::post('/admin/barang/store', 'BarangController@store')->name('barang.store');
    Route::post('/admin/barang/mutasi', 'BarangController@getMutasi')->name('barang.mutasi');
    Route::get('/barang/{kode}', 'BarangController@get_barang')->name('get_barang');
    
    //Mastercard
    Route::name('mastercard.')->prefix('mastercard')->group(function() {
        Route::get('/json', 'MastercardController@json')->name('json');
        Route::get('/get_data', 'MastercardController@select_view')->name('get_data');
        Route::get('/', 'MastercardController@indexb1')->middleware(['auth'])->name('b1');
        Route::get('/dc', 'MastercardController@indexdc')->middleware(['auth'])->name('dc');
        Route::get('/create', 'MastercardController@create')->name('create');
        Route::post('/store', 'MastercardController@store')->name('store');
        Route::get('/edit/{id}', 'MastercardController@edit')->name('edit');
        Route::get('/revisi/{id}', 'MastercardController@revisi')->name('revisi');
        Route::post('/prosesRevisi/{id}', 'MastercardController@saveRevisi')->name('saveRevisi');
        Route::post('/update', 'MastercardController@update')->name('update');
        Route::get('/pdf/{id}', 'MastercardController@pdfprint')->name('pdfb1');
        Route::get('/show/{id}', [MastercardController::class, 'single'])->name('show');
        Route::get('/export', [MastercardController::class, 'export'])->name('export');
    });

    Route::get('mastercard/select', [MastercardController::class, 'select_view'])->name('mastercard.select');

    //Converting
    
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
    Route::get('/admin/kontrak/opened', 'Kontrak_DController@getOpenKontrak')->name('kontrak.opened');
    Route::get('/admin/kontrak/export', 'Kontrak_DController@exportExcel')->name('kontrak.export');
    Route::get('/admin/kontrakall', 'Kontrak_DController@get_all_kontrak')->name('kontrak.all');
    Route::get('/admin/single/{id}', 'Kontrak_DController@single')->name('kontrak.single');

    Route::get('/admin/kontraknew', [Kontrak_DController::class, 'index_new'])->name('kontraknew');

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
    Route::get('/admin/opi/json-paginated', 'OpiController@jsonPaginated')->name('opi.json.paginated');
    Route::get('/test-opi', function() {
        return response()->json(['status' => 'OPI test route working', 'timestamp' => now()]);
    });
    Route::post('/admin/opi/store', 'OpiController@store')->name('opi.store');
    Route::get('/admin/opi/edit/{id}', 'OpiController@edit')->name('opi.edit');
    Route::put('/admin/opi/update/{id}', 'OpiController@update')->name('opi.update');
    Route::get('/admin/opi/print/{id}', 'OpiController@print')->name('opi.print');
    Route::get('/admin/opi/cancel/{id}', 'OpiController@cancel')->name('opi.cancel');
    Route::get('/admin/opi/closed/{id}', 'OpiController@closed')->name('opi.closed');
    Route::get('/admin/opi/single/{id}', 'OpiController@single')->name('opi.single');

    Route::get('/admin/opinew', [OpiController::class, 'index_new'])->name('opinew');
    Route::get('/admin/opi/plan_kirim', [OpiController::class, 'plan_kirim'])->name('opi.plan_kirim');
    Route::get('/admin/opi/plan_kirim/export', [OpiController::class, 'plan_kirim_export'])->name('opi.plan_kirim.export');
    Route::get('/admin/opi/intake', [OpiController::class, 'intakeMonthly'])->name('opi.intake');
    Route::get('/admin/opi/intake/export', [OpiController::class, 'exportIntakeMonthly'])->name('opi.intake.export');
    Route::get('/vendortt/export', function (Request $request){
            $vendortt = VendorTTDet::with('master_vend');
            // dd($request->all());
            // Search filter - pencarian berdasarkan NoTT, BBMNo, InvNumber, PONumber
            if ($request->search) {
                $search = $request->search;
                $vendortt = $vendortt->where(function($query) use ($search) {
                    $query->where('NoTT', 'LIKE', '%' . $search . '%')
                          ->orWhere('BBMNo', 'LIKE', '%' . $search . '%')
                          ->orWhere('InvNumber', 'LIKE', '%' . $search . '%')
                          ->orWhere('PONumber', 'LIKE', '%' . $search . '%');
                });
            }

            // Date range filter
            if ($request->filled('date_start') && $request->filled('date_end')) {
                $dateStart = $request->date_start;
                $dateEnd = $request->date_end;
                
                // Filter berdasarkan Tglterima dari tabel VendorTT
                $vendortt = $vendortt->whereHas('master_vend', function($query) use ($dateStart, $dateEnd) {
                    $query->whereBetween('Tglterima', [$dateStart, $dateEnd]);
                });
            }
            $fileName = 'VendorTT_';
            
            if ($request->filled('date_start') && $request->filled('date_end')) {
                $fileName .= date('Ymd', strtotime($request->date_start)) . '_to_' . date('Ymd', strtotime($request->date_end));
            } elseif ($request->filled('periode_manual')) {
                $fileName .= str_replace(['-', ' '], '_', $request->periode_manual);
            } else {
                $fileName .= date('Ymd');
            }
            
            if ($request->filled('gudang_filter')) {
                $fileName .= '_' . strtolower($request->gudang_filter);
            }
            
            $fileName .= '_' . now()->format('His') . '.xlsx';
            
            return Excel::download(new VendorTTExport($vendortt), $fileName);
    })->name('acc.vendor_tt.export');
    Route::get('/opi/export', function (Request $request) {
        $page = $request->input('page', 1);
        $opi = Opi_M::where('status_opi', '=', 'Proses');

        if($request->search) {
            $opi->where(function($query) use ($request) {
                $query->whereHas('kontrakm', function($q) use ($request) {
                    $q->where('customer_name', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('poCustomer', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('kode', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhere('NoOPI', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('mc', function($q) use ($request) {
                    $q->where('kode', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('namaBarang', 'LIKE', '%' . $request->search . '%');
                });
            });
        }

        $opi = $opi->orderBy('updated_at', 'desc')
            ->orderBy('NoOPI', 'desc')
            ->paginate(50, ['*'], 'page', $page);
        // dd($opi);
        return Excel::download(new OpiExport($opi), 'opi.xlsx');
    })->name('opi.export');
    
    Route::get('/admin/ppic/karet', 'MastercardController@get_mc_php')->name('ppic.karet');
    Route::get('/admin/ppic/test-php-relation', [MastercardController::class, 'test_php_relation'])->name('ppic.test_php');
    Route::post('/admin/ppic/sync-php', [MastercardController::class, 'sync_php_to_mysql'])->name('ppic.sync_php');

    //PLAN
    Route::get('/admin/plan/corr', 'CorrugatedController@index')->middleware(['auth'])->name('admin.corrplan.index');
    Route::get('/admin/plan/create', 'CorrugatedController@create')->middleware(['auth'])->name('admin.corrplan.create');
    Route::post('/admin/plan/corr/store', 'CorrugatedController@store')->middleware(['auth'])->name('admin.corrplan.store');
    Route::get('/admin/plan/corr/{id}/edit', 'CorrugatedController@edit')->middleware(['auth'])->name('admin.corrplan.edit');
    Route::put('/admin/plan/corr/{id}', 'CorrugatedController@update')->middleware(['auth'])->name('admin.corrplan.update');

    
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
    // Route::get('/admin/plan/control', 'CorrController@control')->middleware(['auth'])->name('hasilcorr');
    Route::get('/admin/produksi/datacorr', 'HasilProduksiController@plan_corr')->middleware(['auth'])->name('plan_corr');
    Route::get('/admin/produksi/hasilcorr', 'HasilProduksiController@index_corr')->middleware(['auth'])->name('index_corr');
    Route::get('/admin/produksi/convd_flexo', 'HasilProduksiController@convd_flexo')->middleware(['auth'])->name('convd.flexo');
    Route::get('/admin/produksi/hasilconv', 'HasilProduksiController@index_conv')->middleware(['auth'])->name('conv.hasilflexo');
    Route::get('/admin/produksi/inputhasilcorr/{id}', 'HasilProduksiController@index_detail_corr')->middleware(['auth'])->name('hasilcorr.edit');
    Route::get('/admin/produksi/inputhasilconv/{id}', 'HasilProduksiController@index_detail_conv')->middleware(['auth'])->name('hasilconv.edit');
    // Route::get('/admin/produksi/hasilcorr/edit/{id}', 'HasilProduksiController@input_hasil')->name('hasilcorr.edit');
    // Route::get('/admin/produksi/hasilconv/edit/{id}', 'HasilProduksiController@input_hasil_conv')->name('hasilconv.edit');
    Route::post('/admin/produksi/hasil', 'HasilProduksiController@hasil_produksi')->middleware(['auth'])->name('hasil_produksi');
    // Route::get('/admin/plan/detail/{id}', 'CorrController@show')->middleware(['auth'])->name('detail');

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

        // Route::get('/admin/ppic/opi',  [OpiPPICController::class, 'index'])->name('ppic.opi');
        // Route::get('admin/ppic/opidata', [OpiPPICController::class, 'get_opibyperiode'])->name('ppic.opi.bydate');
        // Route::get('admin/ppic/opi_approve', [OpiPPICController::class, 'approve_opi'])->name('ppic.opi.approve');
        // Route::get('admin/ppic/opi_approve_proses/{id}', [OpiPPICController::class, 'proses_approve'])->name('ppic.opi.proses_approve');

    // Accounting
        // 
        Route::get('admin/acc/mod', [MarektingOrder::class, 'index_acc'])->name('acc.mod.index');
        Route::get('admin/acc/mod/approve/{kode}', [MarektingOrder::class, 'approve_by_acc'])->name('acc.mod.approve');
        Route::post('admin/acc/mod/tolak', [MarektingOrder::class, 'tolak_acc'])->name('acc.mod.disapprove');
        Route::get('admin/acc', [KontrakAccController::class, 'index'])->name('acc.kontrak.index');
        Route::get('admin/acc/kontrak', [KontrakAccController::class, 'json'])->name('acc.kontrak.json');
        Route::get('admin/acc/customer', [FinanceController::class, 'getCust'])->name('acc.cust');
        Route::get('admin/acc/piutang', [FinanceController::class, 'get_piutang'])->name('acc.piutang');        
        Route::get('admin/acc/piutang/{cust}', [FinanceController::class, 'get_piutang_cust'])->name('acc.piutang.cust');
        Route::get('admin/acc/vendortt', [FinanceController::class, 'vendor_tt'])->name('acc.vendortt');
        Route::get('admin/acc/update_po', [FinanceController::class, 'update_po'])->name('acc.update_po');
        Route::get('admin/acc/opi', [FinanceController::class, 'approve_opi'])->name('acc.opi');
        Route::post('admin/acc/opi/approve/{id}', [FinanceController::class, 'approve_opi_action'])->name('acc.opi.approve');
        Route::post('admin/acc/opi/approve-bulk', [FinanceController::class, 'approve_opi_bulk'])->name('acc.opi.approve.bulk');

    // Data
        Route::get('admin/data/sync', [CustomerController::class, 'syncronize'])->name('data.sync');
        Route::get('admin/data/cust', [CustomerController::class, 'index'])->name('data.cust');
        Route::get('admin/data/detbbm', [CustomerController::class, 'getBBM'])->name('data.detbbm');
        Route::get('admin/data/stokroll', [CustomerController::class, 'getStok'])->name('data.stok');
        Route::get('admin/data/alamat', [CustomerController::class, 'alamat_cust'])->name('data.alamat');
        Route::get('/admin/data/sync_fa', [PaletController::class, 'sync_fa'])->name('sync_fa');
        Route::get('admin/cust/single/{id}', [CustomerController::class, 'single_cust'])->name('data.custsingle');
        Route::post('admin/cust/print', [CustomerController::class, 'print_cust'])->name('cust.print');

        Route::get('customer/getdata', [Kontrak_DController::class, 'customer_select'])->name('kontrak.cust');
        Route::get('customer/getdata/{search}', [Kontrak_DController::class, 'customer_search'])->name('kontrak.cust.search');

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

    // BP Converting
        // Route::get('admin/fb/bbm', [CustomerController::class, 'getDetPurchaseOrder'])->name('po');
        Route::get('admin/fb/bbm', [BbmRollController::class, 'getBBM'])->name('fb.list.bbm');
        Route::get('admin/fb/bbm/add', [BbmRollController::class, 'add'])->name('fb.add.bbm');
        Route::post('admin/fb/bbm/store', [BbmRollController::class, 'simpan_bbm'])->name('fb.store.bbm');
        Route::get('admin/po/{supp}', [BbmRollController::class, 'getPurchaseOrderBySupp'])->name('fb.get.po');
        Route::get('admin/po/id/{id}', [BbmRollController::class, 'getDetPoById'])->name('fb.get.byid');
        Route::get('admin/po', [BbmRollController::class, 'getPurchaseOrderAll'])->name('fb.get.poall');
        Route::get('admin/getSupp', [BbmRollController::class, 'getSupp'])->name('get.supp');

        Route::get('admin/fb/bp', [BarangController::class, 'teknik'])->name('fb.list.bp');
        Route::post('admin/fb/bp/mutasi/', [BarangController::class, 'get_mutasi_bp'])->name('fb.bp.mutasi');
        Route::get('admin/fb/bp-lama', [BarangController::class, 'bp_lama'])->name('fb.list.bp_lama');
        Route::post('admin/fb/bp/mutasi-lama/', [BarangController::class, 'get_mutasi_bp_lama'])->name('fb.bp_lama.mutasi');


    // Teknik
        Route::get('admin/fb/getbarang', [BarangTeknikController::class, 'getBarang'])->name('fb.get.teknik');
        Route::get('admin/fb/teknik', [BarangTeknikController::class, 'listBarang'])->name('fb.list.teknik');
        Route::get('/admin/fb/mutasi/{kodebarang}', [BarangTeknikController::class, 'getMutasi'])->name('fb.teknik.mutasi');

    // Marketing
        Route::get('admin/marketing/getformpermintaan', [FormPermintaan::class, 'getPermintaan'])->name('mkt.get.formpermintaan');
        Route::get('admin/marketing/formpermintaan', [FormPermintaan::class, 'listPermintaan'])->name('mkt.list.formpermintaan');
        Route::get('admin/marketing/formpermintaan/add', [FormPermintaan::class, 'add'])->name('mkt.add.formpermintaan');
        Route::post('admin/marketing/formpermintaan/store', [FormPermintaan::class, 'store'])->name('mkt.store.formpermintaan');
        Route::get('admin/marketing/formpermintaan/edit/{id}', [FormPermintaan::class, 'edit'])->name('mkt.edit.formpermintaan');
        Route::put('admin/marketing/formpermintaan/update/{id}', [FormPermintaan::class, 'update'])->name('mkt.update.formpermintaan');

        Route::get('admin/marketing/plan_kirim', [OpiController::class, 'plan_kirim'])->name('mkt.plan.kirim');
        
        Route::get('admin/marketing/getformmc', [FormMc::class, 'getListMc'])->name('mkt.get.formmc');
        Route::get('admin/marketing/formmc', [FormMc::class, 'list'])->name('mkt.list.formmc');
        Route::get('admin/marketing/formmc/add', [FormMc::class, 'add'])->name('mkt.add.formmc');
        Route::post('admin/marketing/formmc/store', [FormMc::class, 'store'])->name('mkt.store.formmc');
        Route::get('admin/marketing/formmc/edit/{kode}', [FormMc::class, 'edit'])->name('mkt.edit.formmc');
        Route::put('admin/marketing/formmc/update/{kode}', [FormMc::class, 'update'])->name('mkt.update.formmc');

        Route::get('admin/marketing/mod_by_tanggal', [MarektingOrder::class, 'get_mod_by_tanggal'])->name('mod.by.tanggal');
        Route::get('admin/marketing/mod_by_tanggal/{tanggal}', [MarektingOrder::class, 'getMod'])->name('mkt.get.mod');
        Route::get('admin/marketing/mod', [MarektingOrder::class, 'index'])->name('mkt.index.mod');
        Route::get('admin/marketing/mod/create', [MarektingOrder::class, 'create'])->name('mkt.create.mod');
        Route::get('/mod_kode/{tujuan}', [MarektingOrder::class, 'get_kode_mod'])->name('mod.get_kode');
        Route::get('/matauang/{kode}', [MarektingOrder::class, 'get_mata_uang'])->name('mod.get_uang');
        Route::get('/detail_mod/{kode}', [MarektingOrder::class, 'get_detail'])->name('detail_mod');
        Route::post('admin/marketing/mod/store', [MarektingOrder::class, 'save_master'])->name('mod.save_master');
        Route::post('admin/marketing/mod/store_detail', [MarektingOrder::class, 'save_detail'])->name('mod.save_detail');
        Route::delete('/mod/delete/{id}', [MarektingOrder::class, 'delete'])->name('mod.delete');
        Route::get('admin/marketing/mod/edit/{id}', [MarektingOrder::class, 'edit'])->name('mkt.edit.mod');
        Route::get('admin/marketing/mod/print/{id}', [MarektingOrder::class, 'print_mod'])->name('mkt.print.mod');

        // Report Marketing
        Route::get('admin/marketing/karet_report', [AlokasiKaretController::class, 'index'])->name('karet.index');
        Route::get('admin/marketing/karet_report/create', [AlokasiKaretController::class, 'create'])->name('karet.create');
        Route::get('admin/marketing/karet_report/{id}', [AlokasiKaretController::class, 'show'])->name('karet.show');
        Route::get('admin/marketing/karet_report/export/excel', [AlokasiKaretController::class, 'export'])->name('karet.export');
        Route::post('admin/marketing/karet_report/store', [AlokasiKaretController::class, 'store'])->name('karet.store');
        Route::put('admin/marketing/karet_report/{id}', [AlokasiKaretController::class, 'update'])->name('karet.update');

        // Forecast Tonase Customer
        Route::get('admin/marketing/forecast_tonase', [ForecastCustController::class, 'index'])->name('forecast.tonase.index');
        Route::get('admin/marketing/forecast_tonase/create', [ForecastCustController::class, 'create'])->name('forecast.tonase.create');
        Route::post('admin/marketing/forecast_tonase/store', [ForecastCustController::class, 'store'])->name('forecast.tonase.store');
        Route::get('admin/marketing/forecast_tonase/edit/{id}', [ForecastCustController::class, 'edit'])->name('forecast.tonase.edit');
        Route::put('admin/marketing/forecast_tonase/update/{id}', [ForecastCustController::class, 'update'])->name('forecast.tonase.update');
        Route::delete('admin/marketing/forecast_tonase/delete/{id}', [ForecastCustController::class, 'destroy'])->name('forecast.tonase.destroy');
        
        // Import & Template
        Route::get('admin/marketing/forecast_tonase/import', [ForecastCustController::class, 'showImport'])->name('forecast.tonase.import.form');
        Route::post('admin/marketing/forecast_tonase/import', [ForecastCustController::class, 'import'])->name('forecast.tonase.import');
        Route::get('admin/marketing/forecast_tonase/template', [ForecastCustController::class, 'downloadTemplate'])->name('forecast.tonase.template');

        Route::get('finance', [FinanceController::class, 'index'])->name('finance');
        Route::post('finance/import', [FinanceController::class, 'import'])->name('finance.import');
        Route::get('finance/faktur', [FinanceController::class, 'index_faktur'])->name('finance.faktur');
        Route::get('finance/getfaktur/', [FinanceController::class, 'get_faktur'])->name('finance.getfaktur');
        Route::get('finance/faktur/print/{kode}', [FinanceController::class, 'print_faktur'])->name('finance.print.faktur');
        
        Route::get('hrd/stationary', [StationaryController::class, 'getBarang'])->name('stationary.barang');

        Route::get('/getnotif', [NavbarController::class, 'getNotifOpenKontrak'])->name('notif.open');
        Route::get('/jobs', [NavbarController::class, 'index'])->name('job.index');
        Route::get('/jobs/create', [NavbarController::class, 'create'])->name('job.create');
        Route::post('/jobs/store', [NavbarController::class, 'store'])->name('job.store');
        Route::get('/jobs/action/{id}', [NavbarController::class, 'update'])->name('job.update');

        
        Route::get('/persediaan', [BarangController::class, 'getPersediaan'])->name('persediaan.bj');

        Route::get('/nomer_opi', [SettingController::class, 'get_opi'])->name('nomer_opi');


        // Inventory Management
        Route::get('/inventory/summary', 'InventoryController@summary')->name('admin.inventory.summary');
        Route::get('/inventory/import/update', 'InventoryController@showImportUpdate')->name('inventory.import.update.form');
        Route::post('/inventory/import/update-rgb', 'InventoryController@importUpdateWithRgb')->name('inventory.import.update.rgb');
        Route::get('/inventory/import/template', 'InventoryController@downloadTemplate')->name('inventory.import.template');
        Route::get('/inventory/import/inventory', 'InventoryController@showImportInventory')->name('inventory.import.inventory.form');
        Route::post('/inventory/import/inventory', 'InventoryController@importInventory')->name('inventory.import.inventory');
        Route::get('/inventory/import/inventory-template', 'InventoryController@downloadInventoryTemplate')->name('inventory.import.inventory.template');
        Route::resource('/inventory', 'InventoryController');
        
        // Inventory Export
        Route::post('/inventory/export', 'InventoryController@export')->name('inventory.export');
        
        Route::resource('/jenis-roll', 'JenisRollController');
        Route::resource('/lebar-roll', 'LebarRollController');
        Route::resource('/supplier-roll', 'SupplierRollController');
        
        // Potongan Management
        Route::resource('/potongan', 'PotongController');
        
        // BBK Roll Management
        Route::resource('/bbk-roll', 'BbkRollController');
        Route::get('/api/bbk-roll/generate-number', 'BbkRollController@generateBbkNumber')->name('bbk-roll.generate-number');
        Route::get('/api/bbk-roll/inventory/{id}/details', 'BbkRollController@getInventoryDetails')->name('bbk-roll.inventory.details');
        
        // BBK Roll Group Operations
        Route::get('/bbk-roll/group/{bbkNumber}/show', 'BbkRollController@showGroup')->name('bbk-roll.show-group');
        Route::get('/bbk-roll/group/{bbkNumber}/edit', 'BbkRollController@editGroup')->name('bbk-roll.edit-group');
        Route::put('/bbk-roll/group/{bbkNumber}/update', 'BbkRollController@updateGroup')->name('bbk-roll.update-group');
        Route::delete('/bbk-roll/group/{bbkNumber}/destroy', 'BbkRollController@destroyGroup')->name('bbk-roll.destroy-group');
        
        // BBK Roll Export
        Route::post('/bbk-roll/export', 'BbkRollController@export')->name('bbk-roll.export');
        
        // BBK Roll Individual Item Operations
        Route::delete('/bbk-roll/delete-item/{bbkRollId}', 'BbkRollController@deleteItem')->name('bbk-roll.delete-item');

        Route::prefix('admin/feedback')->name('admin.feedback.')->group(function () {
            Route::get('/', [FeedbackController::class, 'index'])->name('index');
            Route::get('/create', [FeedbackController::class, 'create'])->name('create');
            Route::post('/store', [FeedbackController::class, 'store'])->name('store');
            Route::get('/{id}', [FeedbackController::class, 'show'])->name('show');
            Route::put('/{id}', [FeedbackController::class, 'update'])->name('update');
            Route::get('/statistics', [FeedbackController::class, 'statistics'])->name('statistics');
        });
        
        // Public feedback submission (can be accessed by any authenticated user)
        Route::post('/feedback/quick-submit', [FeedbackController::class, 'quickSubmit'])->name('admin.feedback.quick-submit');

        // Hardware Template Download (Public access)
        Route::get('hardware/template', 'HardwareController@downloadTemplate')->name('hardware.template');
        // Artisan command for export (public access for simplicity)
        Route::get('artisan/hardware-export', function() {
            Artisan::call('hardware:export');
            return response()->json(['success' => true, 'message' => 'Export completed']);
        });

        Route::resource('hardware', 'HardwareController');
        Route::post('hardware/import', 'HardwareController@import')->name('hardware.import');
        Route::get('hardware/export', 'HardwareController@export')->name('hardware.export');

        Route::prefix('admin/report')->name('admin.report.')->group(function () {
            Route::get('deadstock/', 'ReportController@deadstock')->name('deadstock');
            Route::get('deadstock/export', 'ReportController@exportDeadstockExcel')->name('deadstock.export');
            Route::get('kapasitas/', 'ReportController@kapasitasGudang')->name('kapasitas');
            Route::get('in_out_bound/', 'ReportController@in_out_bound')->name('in_out_bound');
        });

        
        Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company.index');
        Route::post('/company/switch/{companyId}', [App\Http\Controllers\CompanyController::class, 'switchCompany'])->name('company.switch');
        Route::get('/company/info', [App\Http\Controllers\CompanyController::class, 'getCompanyInfo'])->name('company.info');


        //Stellar 

        Route::get('/admin/stellar_bp', [BbmController::class, 'index'])->name('stellar.bp.index');
        Route::get('/admin/stellar_bp/export', [BbmController::class, 'export'])->name('stellar.bp.export');
}); 

require __DIR__ . '/auth.php';
