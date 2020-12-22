<?php

use App\Http\Controllers\SatuansController;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.index');
})->middleware(['auth'])->name('admin');

Route::get('/satuan', [\App\Http\Controllers\SatuansController::class, 'index']);
Route::get('/satuan/create', [\App\Http\Controllers\SatuansController::class, 'create']);
Route::post('/satuan/store', [\App\Http\Controllers\SatuansController::class, 'store']);

require __DIR__.'/auth.php';
