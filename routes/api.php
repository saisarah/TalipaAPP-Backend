<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\CropController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
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


Route::post('/login/send-otp', [LoginController::class, 'sendOtp']);
Route::post('/login/verify-otp', [LoginController::class, 'verifyOtp']);

Route::post('/register/vendor', [RegisterController::class, 'registerFarmer']);
Route::post('/register/farmer', [RegisterController::class, 'registerVendor']);
Route::post('/register/validator', [RegisterController::class, 'validator']);

Route::get('/philippine-addresses/regions', [AddressController::class, 'regions']);
Route::get('/philippine-addresses/provinces', [AddressController::class, 'provinces']);
Route::get('/philippine-addresses/cities', [AddressController::class, 'cities']);
Route::get('/philippine-addresses/barangays', [AddressController::class, 'barangays']);
Route::get('/posts', [PostController::class, 'index'])->middleware('auth:sanctum');
Route::get('/crops', [CropController::class, 'index'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'getCurrentUser'])->middleware('auth:sanctum');

Route::post('/posts', [PostController::class, 'create'])->middleware('auth:sanctum');
