<?php

use App\Http\Controllers\AutoCompleteController;
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

Route::resource('satuans', SatuansController::class);
Route::resource('supplier', SuppliersController::class);
Route::resource('barang', BarangController::class);
Route::resource('mastercard', MastercardController::class);
// Route::get('/generateNumberSequence', MastercardController::class, 'generateNumberSequence');

require __DIR__.'/auth.php';
