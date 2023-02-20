<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\CropController;
use App\Http\Controllers\API\DemandController;
use App\Http\Controllers\API\FarmerController;
use App\Http\Controllers\API\FarmerGroupController;
use App\Http\Controllers\API\FarmerGroupPostController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VendorController;
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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register/send-otp', [RegisterController::class, 'sendOtp']);

Route::post('/register/vendor', [RegisterController::class, 'registerVendor']);
Route::post('/register/farmer', [RegisterController::class, 'registerFarmer']);
Route::post('/register/validator', [RegisterController::class, 'validator']);

Route::get('/crops', [CropController::class, 'index']);

Route::get('/philippine-addresses/regions', [AddressController::class, 'regions']);
Route::get('/philippine-addresses/provinces', [AddressController::class, 'provinces']);
Route::get('/philippine-addresses/cities', [AddressController::class, 'cities']);
Route::get('/philippine-addresses/barangays', [AddressController::class, 'barangays']);
Route::get('/posts', [PostController::class, 'index'])->middleware('auth:sanctum');
Route::get('/posts/{post}', [PostController::class, 'show'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'getCurrentUser'])->middleware('auth:sanctum');

Route::post('/posts', [PostController::class, 'create'])->middleware('auth:sanctum');
Route::get('/users/{user}/posts', [PostController::class, 'getFromUser'])->middleware('auth:sanctum');

Route::get('/farmer-groups', [FarmerGroupController::class, 'index'])->middleware('auth:sanctum');
Route::get('/farmer-groups/{id}', [FarmerGroupController::class, 'show'])->middleware('auth:sanctum');
Route::get('/farmers', [FarmerController::class, 'index']);
Route::get('/farmer-group-posts', [FarmerGroupPostController::class, 'index'])->middleware('auth:sanctum');
Route::get('/farmer-group', [FarmerGroupController::class, 'getCurrentGroup'])->middleware('auth:sanctum');

Route::get('/vendors', [VendorController::class, 'index']);

Route::get('/demands', [DemandController::class, 'index']);

Route::get('/messages', [MessageController::class, 'index'])->middleware('auth:sanctum');
Route::get('/messages/{id}', [MessageController::class, 'show'])->middleware('auth:sanctum');
Route::post('/messages/{id}', [MessageController::class, 'create'])->middleware('auth:sanctum');


Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
