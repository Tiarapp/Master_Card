<?php

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
    return view('admin.index');
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
    Route::put('/admin/box/update/{id}', 'BoxController@update');
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
    
    //Wax
    Route::get('/admin/wax', 'WaxController@index')->name('wax');
    Route::get('/admin/wax/create', 'WaxController@create')->name('wax.create');
    Route::post('/admin/wax/store', 'WaxController@store')->name('wax.store');
    Route::get('/admin/wax/show/{id}', 'WaxController@show');
    Route::get('/admin/wax/edit/{id}', 'WaxController@edit');
    Route::put('/admin/wax/update/{id}', 'WaxController@update');
    Route::get('/admin/wax/delete/{id}', 'WaxController@updateDeleted');
    
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
    Route::get('/admin/mastercard/b1', 'MastercardController@indexb1')->middleware(['auth'])->name('mastercardb1');
    Route::get('/admin/mastercard/dc', 'MastercardController@indexdc')->middleware(['auth'])->name('mastercarddc');
    Route::get('/admin/mastercard/create', 'MastercardController@create')->name('mastercard.create');
    Route::post('/admin/mastercard/store', 'MastercardController@store')->name('mastercard.store');
    Route::get('/admin/mastercard/edit/{id}', 'MastercardController@edit')->name('mastercard.edit');
    Route::post('/admin/mastercard/update', 'MastercardController@update')->name('mastercard.update');
    Route::get('/admin/mastercard/pdf/{id}', 'MastercardController@pdfprint')->name('mastercard.pdfb1');

    //Kontrak
    Route::get('/admin/kontrak', 'Kontrak_DController@index')->middleware(['auth'])->name('kontrak');
    Route::get('/admin/kontrak/json', 'Kontrak_DController@json')->name('kontrak.json');
    Route::get('/admin/kontrak/create', 'Kontrak_DController@create')->name('kontrak.create');
    Route::post('/admin/kontrak/store', 'Kontrak_DController@store')->name('kontrak.store');
    Route::post('/admin/kontrak/store_realisasi', 'Kontrak_DController@store_realisasi')->name('kontrak.store_realisasi');
    Route::get('/admin/kontrak/edit/{id}', 'Kontrak_DController@edit')->name('kontrak.edit');
    Route::get('/admin/kontrak/realisasi/{id}', 'Kontrak_DController@add_realisasi')->name('kontrak.realisasi');
    Route::get('/admin/kontrak/dt/{id}', 'Kontrak_DController@add_dt')->name('kontrak.dt');
    Route::post('/admin/kontrak/store_dt', 'Kontrak_DController@store_dt')->name('kontrak.store_dt');
    Route::put('/admin/kontrak/update/{id}', 'Kontrak_DController@update')->name('kontrak.update');
    Route::get('/admin/kontrak/pdf/{id}', 'Kontrak_DController@pdfprint')->name('kontrak.pdfb1');

    //OPI
    Route::get('/admin/opi', 'OpiController@index')->middleware(['auth'])->name('opi');
    Route::get('/admin/opi/create', 'OpiController@create')->name('opi.create');
    Route::get('/admin/opi/json', 'OpiController@json')->name('opi.json');
    Route::post('/admin/opi/store', 'OpiController@store')->name('opi.store');
    Route::get('/admin/opi/edit/{id}', 'OpiController@edit')->name('opi.edit');
    Route::put('/admin/opi/update/{id}', 'OpiController@update')->name('opi.update');
    Route::get('/admin/opi/print/{id}', 'OpiController@print')->name('opi.print');

    //PLAN
    Route::get('/admin/plan/corr', 'CorrController@index')->middleware(['auth'])->name('indexcorr');
    Route::get('/admin/plan/corrm', 'CorrController@corrm')->middleware(['auth'])->name('corrm');
    Route::get('/admin/plan/corr/create', 'CorrController@create')->name('corr.create');
    Route::get('/admin/plan/corr/json', 'CorrController@json')->name('corr.json');
    Route::post('/admin/plan/corr/store', 'CorrController@store')->name('corr.store');
    Route::get('/admin/plan/corr/edit/{id}', 'CorrController@edit')->name('corr.edit');
    Route::put('/admin/plan/corr/update/{id}', 'CorrController@update')->name('corr.update');
    Route::get('/admin/plan/corr/print/{id}', 'CorrController@corr_pdf')->name('corr.print');

    
    Route::get('/admin/plan/conv', 'ConvController@index_printing_conv')->middleware(['auth'])->name('conv');
    Route::get('/admin/plan/conv/flexoacreate', 'ConvController@createFlexoA')->middleware(['auth'])->name('flexoa.create');
    Route::post('/admin/plan/conv/storenonprint', 'ConvController@storeNonPrinting')->middleware(['auth'])->name('conv.storenonprint');
    Route::get('/admin/plan/conv/createprinting', 'ConvController@create_printing')->name('conv.create_printing');
    Route::get('/admin/plan/conv/createnonprinting', 'ConvController@create_non_printing')->name('conv.create_non_printing');
    Route::get('/admin/plan/conv/convd', 'ConvController@convd')->name('convd');
    Route::get('/admin/plan/conv/convm', 'ConvController@convm')->name('convm');
    Route::get('/admin/plan/conv/json', 'ConvController@json')->name('conv.json');
    Route::post('/admin/plan/conv/flexoastore', 'ConvController@storeFlexoA')->name('conv.storeflexoa');
    Route::get('/admin/plan/conv/edit/{id}', 'ConvController@edit')->name('conv.edit');
    Route::put('/admin/plan/conv/update/{id}', 'ConvController@update')->name('conv.update');
    Route::get('/admin/plan/conv/print/{id}', 'ConvController@conv_pdf')->name('conv.print');

    //Hasil Corr
    Route::get('/admin/plan/hasilcorr', 'CorrController@index_hasil_corr')->middleware(['auth'])->name('hasilcorr');
    Route::get('/admin/plan/corrd', 'CorrController@corrd')->middleware(['auth'])->name('corrd');
    Route::get('/admin/plan/hasilcorr/edit/{id}', 'CorrController@edit_hasil_corr')->name('hasilcorr.edit');
    Route::put('/admin/plan/hasilcorr/update/{id}', 'CorrController@update_hasil_corr')->name('hasilcorr.update');
    Route::get('/admin/plan/hasilcorr/print/{id}', 'CorrController@corr_pdf')->name('corr.print');


    //Hasil Converting
    Route::get('/admin/plan/hasilconvflexo', 'ConvController@index_hasil_flexo')->middleware(['auth'])->name('conv.hasilflexo');
    Route::get('/admin/plan/hasil/control', 'ConvController@control')->middleware(['auth'])->name('conv.control');
    Route::get('/admin/plan/hasilconvstich', 'ConvController@index_hasil_stich')->middleware(['auth'])->name('conv.hasilstich');
    Route::get('/admin/plan/hasilconvtokai', 'ConvController@index_hasil_tokai')->middleware(['auth'])->name('conv.hasiltokai');
    Route::get('/admin/plan/hasilconvwax', 'ConvController@index_hasil_wax')->middleware(['auth'])->name('conv.hasilwax');
    Route::get('/admin/plan/hasilconvslitter', 'ConvController@index_hasil_slitter')->middleware(['auth'])->name('conv.hasilslitter');
    Route::get('/admin/plan/hasilconvglue', 'ConvController@index_hasil_glue')->middleware(['auth'])->name('conv.hasilglue');
    Route::get('/admin/plan/convd_flexo', 'ConvController@convd_flexo')->middleware(['auth'])->name('convd.flexo');
    Route::get('/admin/plan/convd_tokai', 'ConvController@convd_tokai')->middleware(['auth'])->name('convd.tokai');
    Route::get('/admin/plan/convd_stich', 'ConvController@convd_stich')->middleware(['auth'])->name('convd.stich');
    Route::get('/admin/plan/convd_wax', 'ConvController@convd_wax')->middleware(['auth'])->name('convd.wax');
    Route::get('/admin/plan/convd_slitter', 'ConvController@convd_slitter')->middleware(['auth'])->name('convd.slitter');
    Route::get('/admin/plan/convd_glue', 'ConvController@convd_glue')->middleware(['auth'])->name('convd.glue');
    Route::post('/admin/plan/conv/storehasilconv', 'ConvController@storeEdit')->name('conv.storehasilconv');
    Route::get('/admin/plan/hasilconvflexo/edit/{id}', 'ConvController@edit_hasil_conv')->name('hasilconv.edit');
    Route::put('/admin/plan/hasilconv/update/{id}', 'ConvController@update_hasil_conv')->name('hasilconv.update');
    Route::get('/admin/plan/hasilconv/print/{id}', 'ConvController@conv_pdf')->name('conv.print');    

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

    //OPNAME
    // Route::get('/admin/opname', 'OPController@index')->middleware(['auth'])->name('op');
    // Route::get('/admin/opname/sheet', 'OPController@indexopSheet')->name('opsheet.index');
    // Route::post('/admin/opname/sheet/store', 'OPController@storeOpSheet')->name('opsheet.store');
    // Route::get('/admin/opname/sheet/create', 'OPController@createOpSheet')->name('opsheet.create');
    // Route::get('/admin/opname/sheet/result', 'OPController@resultOpSheet')->name('opsheet.result');
    // Route::get('/admin/opname/sheet/edit/{KodeBrg}', 'OPController@editOpSheet')->name('opsheet.edit');
    // Route::post('/admin/opname/sheet/import', 'OPController@import_sheet')->name('opsheet.import');
    
    // Route::get('/admin/opname/roll', 'OPController@indexOpRoll')->name('oproll.index');
    // Route::post('/admin/opname/roll/store', 'OPController@storeOpRoll')->name('oproll.store');
    // Route::get('/admin/opname/roll/create', 'OPController@createOpRoll')->name('oproll.create');
    // Route::get('/admin/opname/roll/result', 'OPController@resultOpRoll')->name('oproll.result');
    // Route::get('/admin/opname/roll/edit/{KodeBrg}', 'OPController@editOpRoll')->name('oproll.edit');
    // Route::post('/admin/opname/roll/import', 'OPController@import_roll')->name('oproll.import');
    
    // Route::get('/admin/opname/bj', 'OPController@indexOpBJ')->name('opbj.index');
    // Route::post('/admin/opname/bj/store', 'OPController@storeOpBJ')->name('opbj.store');
    // Route::get('/admin/opname/bj/create', 'OPController@createOpBJ')->name('opbj.create');
    // Route::get('/admin/opname/bj/result', 'OPController@resultOpBJ')->name('opbj.result');
    // Route::get('/admin/opname/bj/edit/{KodeBrg}', 'OPController@editOpBJ')->name('opbj.edit');
    // Route::post('/admin/opname/bj/import', 'OPController@import_bj')->name('opbj.import');
    
    // Route::get('/admin/opname/teknik', 'OPController@indexOpTeknik')->name('opteknik.index');
    // Route::post('/admin/opname/teknik/store', 'OPController@storeOpTeknik')->name('opteknik.store');
    // Route::get('/admin/opname/teknik/create', 'OPController@createOpTeknik')->name('opteknik.create');
    // Route::get('/admin/opname/teknik/result', 'OPController@resultOpTeknik')->name('opteknik.result');
    // Route::get('/admin/opname/teknik/edit/{KodeBrg}', 'OPController@editOpTeknik')->name('opteknik.edit');
    // Route::post('/admin/opname/teknik/import', 'OPController@import_teknik')->name('opteknik.import');


    //
    Route::get('/admin/address', 'ProvincesController@index')->middleware(['auth'])->name('address');
});



require __DIR__ . '/auth.php';
