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
    return view('admin.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/satuans', 'SatuansController@index');
Route::get('/admin/satuans/edit/{id}', 'SatuansController@edit');
Route::put('/admin/satuans/update/{id}', 'SatuansController@update');
Route::get('/admin/satuans/delete/{id}', 'SatuansController@updateDeleted');



Route::resource('supplier', SuppliersController::class);
Route::resource('barang', BarangController::class);
Route::resource('mastercard', MastercardController::class);

require __DIR__ . '/auth.php';
