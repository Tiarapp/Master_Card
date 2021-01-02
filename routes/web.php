<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\MastercardController;
use App\Http\Controllers\SatuansController;
use App\Http\Controllers\SuppliersController;
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

//Sales
Route::get('/admin/sales', 'SalesController@index');
Route::get('/admin/sales/create', 'SalesController@create');
Route::post('/admin/sales/store', 'SalesController@store');
Route::get('/admin/sales/show/{id}', 'SalesController@show');
Route::get('/admin/sales/edit/{id}', 'SalesController@edit');
Route::put('/admin/sales/update/{id}', 'SalesController@update');
Route::get('/admin/sales/delete/{id}', 'SalesController@updateDeleted');

Route::resource('supplier', SuppliersController::class);
Route::resource('barang', BarangController::class);
Route::resource('mastercard', MastercardController::class);

require __DIR__ . '/auth.php';
