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
    Route::get('/admin/mastercard', 'MastercardController@index')->middleware(['auth'])->name('mastercard');
    Route::get('/admin/mastercard/create', 'MastercardController@create')->name('mastercard.create');
    Route::post('/admin/mastercard/store', 'MastercardController@store')->name('mastercard.store');
    Route::get('/admin/mastercard/edit/{id}', 'MastercardController@edit')->name('mastercard.edit');
    Route::get('/admin/mastercard/pdf/{id}', 'MastercardController@pdfprint')->name('mastercard.pdfb1');

    //Kontrak
    Route::get('/admin/kontrak', 'Kontrak_DController@index')->middleware(['auth'])->name('kontrak');
    Route::get('/admin/kontrak/create', 'Kontrak_DController@create')->name('kontrak.create');
    Route::post('/admin/kontrak/store', 'Kontrak_DController@store')->name('kontrak.store');
    Route::get('/admin/kontrak/edit/{id}', 'Kontrak_DController@edit')->name('kontrak.edit');
    Route::put('/admin/kontrak/update/{id}', 'Kontrak_DController@update')->name('kontrak.update');
    Route::get('/admin/kontrak/pdf/{id}', 'Kontrak_DController@pdfprint')->name('kontrak.pdfb1');

    //OPI
    Route::get('/admin/opi', 'OpiController@index')->middleware(['auth'])->name('opi');
    Route::get('/admin/opi/create', 'OpiController@create')->name('opi.create');
    Route::post('/admin/opi/store', 'OpiController@store')->name('opi.store');
    Route::get('/admin/opi/edit/{id}', 'OpiController@edit')->name('opi.edit');
    Route::put('/admin/opi/update/{id}', 'OpiController@update')->name('opi.update');
    Route::get('/admin/opi/pdf/{id}', 'OpiController@pdfprint')->name('opi.pdfb1');

    //OPNAME
    Route::get('/admin/opname', 'OPController@index')->middleware(['auth'])->name('op');
    Route::get('/admin/opname/sheet', 'OPController@indexopSheet')->name('opsheet.index');
    Route::post('/admin/opname/sheet/store', 'OPController@storeOpSheet')->name('opsheet.store');
    Route::get('/admin/opname/sheet/create', 'OPController@createOpSheet')->name('opsheet.create');
    Route::get('/admin/opname/sheet/result', 'OPController@resultOpSheet')->name('opsheet.result');
    Route::get('/admin/opname/sheet/edit/{KodeBrg}', 'OPController@editOpSheet')->name('opsheet.edit');
    Route::post('/admin/opname/sheet/import', 'OPController@import_sheet')->name('opsheet.import');
    
    Route::get('/admin/opname/roll', 'OPController@indexOpRoll')->name('oproll.index');
    Route::post('/admin/opname/roll/store', 'OPController@storeOpRoll')->name('oproll.store');
    Route::get('/admin/opname/roll/create', 'OPController@createOpRoll')->name('oproll.create');
    Route::get('/admin/opname/roll/result', 'OPController@resultOpRoll')->name('oproll.result');
    Route::get('/admin/opname/roll/edit/{KodeBrg}', 'OPController@editOpRoll')->name('oproll.edit');
    Route::post('/admin/opname/roll/import', 'OPController@import_roll')->name('oproll.import');
    
    Route::get('/admin/opname/bj', 'OPController@indexOpBJ')->name('opbj.index');
    Route::post('/admin/opname/bj/store', 'OPController@storeOpBJ')->name('opbj.store');
    Route::get('/admin/opname/bj/create', 'OPController@createOpBJ')->name('opbj.create');
    Route::get('/admin/opname/bj/result', 'OPController@resultOpBJ')->name('opbj.result');
    Route::get('/admin/opname/bj/edit/{KodeBrg}', 'OPController@editOpBJ')->name('opbj.edit');
    Route::post('/admin/opname/bj/import', 'OPController@import_bj')->name('opbj.import');
    
    Route::get('/admin/opname/teknik', 'OPController@indexOpTeknik')->name('opteknik.index');
    Route::post('/admin/opname/teknik/store', 'OPController@storeOpTeknik')->name('opteknik.store');
    Route::get('/admin/opname/teknik/create', 'OPController@createOpTeknik')->name('opteknik.create');
    Route::get('/admin/opname/teknik/result', 'OPController@resultOpTeknik')->name('opteknik.result');
    Route::get('/admin/opname/teknik/edit/{KodeBrg}', 'OPController@editOpTeknik')->name('opteknik.edit');
    Route::post('/admin/opname/teknik/import', 'OPController@import_teknik')->name('opteknik.import');


    //
    Route::get('/admin/address', 'ProvincesController@index')->middleware(['auth'])->name('address');
});



require __DIR__ . '/auth.php';
