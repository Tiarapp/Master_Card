<?php

use App\Http\Controllers\SatuansController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.index');
})->middleware(['auth'])->name('admin');

Route::resource('satuans',SatuansController::class);

// Route::get('/satuan', [\App\Http\Controllers\SatuansController::class, 'index']);
// Route::get('/satuan/create', [\App\Http\Controllers\SatuansController::class, 'create']);
// Route::post('/satuan/store', [\App\Http\Controllers\SatuansController::class, 'store']);
// Route::get('/satuan/edit/{id}', [\App\Http\Controllers\SatuansController::class, 'edit']);

require __DIR__.'/auth.php';
