<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\MastercardController;
use App\Http\Controllers\Api\BbmController;
use App\Http\Controllers\Api\KontrakController;
use App\Http\Controllers\Api\MasterdataController;
use App\Http\Controllers\Api\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Customer API routes
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);

// Mastercard API routes
Route::get('/mastercards', [MastercardController::class, 'index']);
Route::get('/mastercards/{id}', [MastercardController::class, 'show']);

// BBM API routes
Route::get('/bbm', [BbmController::class, 'index']);
Route::get('/bbm/{id}', [BbmController::class, 'show']);

// Kontrak API routes
Route::get('/kontraks', [KontrakController::class, 'index']);
Route::get('/kontraks/{id}', [KontrakController::class, 'show']);

// masterdata API route
Route::get('/masterdata/{type}', [MasterdataController::class, 'get_masterdata_by_type']);
Route::get('/masterdata/id/{id}', [MasterdataController::class, 'get_masterdata_by_id']);
Route::post('/masterdata', [MasterdataController::class, 'store'])->name('masterdata.store');

// Vehicle API route
Route::get('/vehicle/{nopol}', [VehicleController::class, 'get_vehicle_by_nopol']);
Route::get('/vehicle/photos/{id}', [VehicleController::class, 'get_vehicle_by_transaction']);
