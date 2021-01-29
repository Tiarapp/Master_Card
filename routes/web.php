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

//Satuan
Route::get('/admin/satuans', 'SatuansController@index')->name('satuans');
Route::get('/admin/satuans/create', 'SatuansController@create');
Route::post('/admin/satuans/store', 'SatuansController@store');
Route::get('/admin/satuans/edit/{id}', 'SatuansController@edit');
Route::put('/admin/satuans/update/{id}', 'SatuansController@update');
Route::get('/admin/satuans/show/{id}', 'SatuansController@show');
Route::get('/admin/satuans/delete/{id}', 'SatuansController@updateDeleted');

//Divisi
Route::get('/admin/divisi', 'DivisiController@index');
Route::get('/admin/divisi/create', 'DivisiController@create');
Route::post('/admin/divisi/store', 'DivisiController@store');
Route::get('/admin/divisi/show/{id}', 'DivisiController@show');
Route::get('/admin/divisi/edit/{id}', 'DivisiController@edit');
Route::put('/admin/divisi/update/{id}', 'DivisiController@update');
Route::get('/admin/divisi/delete/{id}', 'DivisiController@updateDeleted');

//Flute
Route::get('/admin/flute', 'FluteController@index');
Route::get('/admin/flute/create', 'FluteController@create');
Route::post('/admin/flute/store', 'FluteController@store');
Route::get('/admin/flute/show/{id}', 'FluteController@show');
Route::get('/admin/flute/edit/{id}', 'FluteController@edit');
Route::put('/admin/flute/update/{id}', 'FluteController@update');
Route::get('/admin/flute/delete/{id}', 'FluteController@updateDeleted');

//Mata Uang
Route::get('/admin/matauang', 'MataUangController@index')->name('matauang');
Route::get('/admin/matauang/create', 'MataUangController@create');
Route::post('/admin/matauang/store', 'MataUangController@store');
Route::get('/admin/matauang/show/{id}', 'MataUangController@show');
Route::get('/admin/matauang/edit/{id}', 'MataUangController@edit');
Route::put('/admin/matauang/update/{id}', 'MataUangController@update');
Route::get('/admin/matauang/delete/{id}', 'MataUangController@updateDeleted');

//Joint
Route::get('/admin/joint', 'JointController@index')->name('joint');
Route::get('/admin/joint/create', 'JointController@create');
Route::post('/admin/joint/store', 'JointController@store');
Route::get('/admin/joint/show/{id}', 'JointController@show');
Route::get('/admin/joint/edit/{id}', 'JointController@edit');
Route::put('/admin/joint/update/{id}', 'JointController@update');
Route::get('/admin/joint/delete/{id}', 'JointController@updateDeleted');

//Sheet
Route::get('/admin/sheet', 'SheetController@index')->name('sheet');
Route::get('/admin/sheet/create', 'SheetController@create');
Route::post('/admin/sheet/store', 'SheetController@store');
Route::get('/admin/sheet/show/{id}', 'SheetController@show');
Route::get('/admin/sheet/edit/{id}', 'SheetController@edit');
Route::put('/admin/sheet/update/{id}', 'SheetController@update');
Route::get('/admin/sheet/delete/{id}', 'SheetController@updateDeleted');

//Box
Route::get('/admin/box', 'BoxController@index')->name('box');
Route::get('/admin/box/create', 'BoxController@create');
Route::post('/admin/box/store', 'BoxController@store');
Route::get('/admin/box/show/{id}', 'BoxController@show');
Route::get('/admin/box/edit/{id}', 'BoxController@edit');
Route::put('/admin/box/update/{id}', 'BoxController@update');
Route::get('/admin/box/delete/{id}', 'BoxController@updateDeleted');

//Koli
Route::get('/admin/koli', 'KoliController@index')->name('koli');
Route::get('/admin/koli/create', 'KoliController@create');
Route::post('/admin/koli/store', 'KoliController@store');
Route::get('/admin/koli/show/{id}', 'KoliController@show');
Route::get('/admin/koli/edit/{id}', 'KoliController@edit');
Route::put('/admin/koli/update/{id}', 'KoliController@update');
Route::get('/admin/koli/delete/{id}', 'KoliController@updateDeleted');

//Substance
Route::get('/admin/substance', 'SubstanceController@index')->name('substance');
Route::get('/admin/substance/create', 'SubstanceController@create');
Route::post('/admin/substance/store', 'SubstanceController@store');
Route::get('/admin/substance/show/{id}', 'SubstanceController@show');
Route::get('/admin/substance/edit/{id}', 'SubstanceController@edit');
Route::put('/admin/substance/update/{id}', 'SubstanceController@update');
Route::get('/admin/substance/delete/{id}', 'SubstanceController@updateDeleted');

//Jenis Gram
Route::get('/admin/jenisgram', 'JenisGramController@index')->name('jenisgram');
Route::get('/admin/jenisgram/create', 'JenisGramController@create');
Route::post('/admin/jenisgram/store', 'JenisGramController@store');
Route::get('/admin/jenisgram/show/{id}', 'JenisGramController@show');
Route::get('/admin/jenisgram/edit/{id}', 'JenisGramController@edit');
Route::put('/admin/jenisgram/update/{id}', 'JenisGramController@update');
Route::get('/admin/jenisgram/delete/{id}', 'JenisGramController@updateDeleted');

//Wax
Route::get('/admin/wax', 'WaxController@index')->name('wax');
Route::get('/admin/wax/create', 'WaxController@create');
Route::post('/admin/wax/store', 'WaxController@store');
Route::get('/admin/wax/show/{id}', 'WaxController@show');
Route::get('/admin/wax/edit/{id}', 'WaxController@edit');
Route::put('/admin/wax/update/{id}', 'WaxController@update');
Route::get('/admin/wax/delete/{id}', 'WaxController@updateDeleted');

//Tipe Box
Route::get('/admin/boxtype', 'BoxTypeController@index')->name('boxtype');
Route::get('/admin/boxtype/create', 'BoxTypeController@create');
Route::post('/admin/boxtype/store', 'BoxTypeController@store');
Route::get('/admin/boxtype/show/{id}', 'BoxTypeController@show');
Route::get('/admin/boxtype/edit/{id}', 'BoxTypeController@edit');
Route::put('/admin/boxtype/update/{id}', 'BoxTypeController@update');
Route::get('/admin/boxtype/delete/{id}', 'BoxTypeController@updateDeleted');

//Warna
Route::get('/admin/warna', 'WarnaController@index')->name('warna');
Route::get('/admin/warna/create', 'WarnaController@create');
Route::post('/admin/warna/store', 'WarnaController@store');
Route::get('/admin/warna/show/{id}', 'WarnaController@show');
Route::get('/admin/warna/edit/{id}', 'WarnaController@edit');
Route::put('/admin/warna/update/{id}', 'WarnaController@update');
Route::get('/admin/warna/delete/{id}', 'WarnaController@updateDeleted');

//Warna Combine
Route::get('/admin/colorcombine', 'ColorCombineController@index')->name('colorcombine');
Route::get('/admin/colorcombine/create', 'ColorCombineController@create');
Route::post('/admin/colorcombine/store', 'ColorCombineController@store');


//Sales
Route::get('/admin/sales', 'SalesController@index');
Route::get('/admin/sales/create', 'SalesController@create');
Route::post('/admin/sales/store', 'SalesController@store');
Route::get('/admin/sales/show/{id}', 'SalesController@show');
Route::get('/admin/sales/edit/{id}', 'SalesController@edit');
Route::put('/admin/sales/update/{id}', 'SalesController@update');
Route::get('/admin/sales/delete/{id}', 'SalesController@updateDeleted');

//Supplier
Route::get('/admin/supplier', 'SuppliersController@index')->name('supplier');
Route::get('/admin/supplier/show/{id}', 'SuppliersController@show')->name('supplier.show');

//Barang
Route::get('/admin/barang', 'BarangController@index')->name('barang');

Route::get('/admin/mastercard', 'MastercardController@index')->name('mastercard');
Route::get('/admin/mastercard/create', 'MastercardController@create')->name('mastercard.create');
Route::post('/admin/mastercard/store', 'MastercardController@store')->name('mastercard.store');
Route::get('/admin/mastercard/edit/{id}', 'MastercardController@edit')->name('mastercard.edit');
Route::get('/admin/mastercard/pdf', 'MastercardController@pdfprint');

require __DIR__ . '/auth.php';
