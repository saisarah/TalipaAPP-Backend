<?php

use App\Http\Controllers\API\Auth\FarmerRegisterController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\VendorRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login/send-otp', [LoginController::class, 'sendOtp']);
Route::post('/login/verify-otp', [LoginController::class, 'verifyOtp']);

Route::post('/register/vendor', [VendorRegisterController::class, 'register']);
Route::post('/register/farmer', [FarmerRegisterController::class, 'register']);

Route::get('/philippine-addresses/regions', [AddressController::class, 'regions']);
Route::get('/philippine-addresses/provinces', [AddressController::class, 'provinces']);
Route::get('/philippine-addresses/cities', [AddressController::class, 'cities']);
Route::get('/philippine-addresses/barangays', [AddressController::class, 'barangays']);

