<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\CropController;
use App\Http\Controllers\API\DemandController;
use App\Http\Controllers\API\FarmerController;
use App\Http\Controllers\API\FarmerGroupController;
use App\Http\Controllers\API\FarmerGroupMemberController;
use App\Http\Controllers\API\FarmerGroupPostController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\Payment\CashInController;
use App\Http\Controllers\API\Payment\PaymentReceivedController;
use App\Http\Controllers\API\Payment\VerifyPaymentController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VendorController;
use App\Models\FarmerGroup;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Api\V2010\Account\AddressContext;

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
Broadcast::routes(['middleware' => 'auth:sanctum']);

Route::post('/login/send-otp', [LoginController::class, 'sendOtp']);
Route::post('/login/verify-otp', [LoginController::class, 'verifyOtp']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register/send-otp', [RegisterController::class, 'sendOtp']);
Route::post('/admin-login', [LoginController::class, 'loginAdmin']);

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
Route::get('/user/transactions', [UserController::class, 'transactions'])->middleware('auth:sanctum');
Route::get('/user/balance', [UserController::class, 'showBalance'])->middleware('auth:sanctum', 'has_wallet');
Route::get('/user/address/complete', [UserController::class, 'showCompleteAddress'])->middleware('auth:sanctum');
Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::get('/user/address', [AddressController::class, 'index'])->middleware('auth:sanctum');
Route::put('/user/address', [AddressController::class, 'update'])->middleware('auth:sanctum');

Route::post('/posts', [PostController::class, 'create'])->middleware('auth:sanctum');
Route::get('/users/{user}/posts', [PostController::class, 'getFromUser'])->middleware('auth:sanctum');

Route::get('/farmer-groups', [FarmerGroupController::class, 'index'])->middleware('auth:sanctum');
Route::get('/farmer-groups/{id}', [FarmerGroupController::class, 'show'])->middleware('auth:sanctum');
Route::get('/farmers', [FarmerController::class, 'index']);
Route::get('/farmer-group-posts', [FarmerGroupPostController::class, 'index'])->middleware('auth:sanctum');
Route::get('/farmer-group', [FarmerGroupController::class, 'getCurrentGroup'])->middleware('auth:sanctum');
Route::post('/farmer-group-posts', [FarmerGroupPostController::class, 'create'])->middleware('auth:sanctum', 'has_group');
Route::post('/farmer-groups/{id}/join', [FarmerGroupMemberController::class, 'join'])->middleware('auth:sanctum');
Route::post('/farmer-groups/members/invite', [FarmerGroupMemberController::class, 'invite'])->middleware('auth:sanctum','farmer', 'has_group', 'president');
Route::post('/farmer-groups', [FarmerGroupController::class, 'create'])->middleware('auth:sanctum','farmer');
Route::post('/farmer-groups/{id}/accept', [FarmerGroupMemberController::class, 'acceptInvitation'])->middleware('auth:sanctum','farmer');
Route::post('/farmer-groups/members/{id}/accept', [FarmerGroupController::class, 'approved'])->middleware('auth:sanctum','farmer', 'has_group', 'president');

Route::get('/vendors', [VendorController::class, 'index']);

Route::get('/demands', [DemandController::class, 'index']);
Route::post('/demands', [DemandController::class, 'create'])->middleware('auth:sanctum', 'vendor');
Route::post('/demands/{id}',[DemandController::class, 'show'])->middleware('auth:sanctum');



Route::get('/messages', [MessageController::class, 'index'])->middleware('auth:sanctum');
Route::get('/messages/{id}', [MessageController::class, 'show'])->middleware('auth:sanctum');
Route::post('/messages/{id}', [MessageController::class, 'create'])->middleware('auth:sanctum');


Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('auth:sanctum');
Route::post('/posts/{post}/order', [OrderController::class, 'create'])->middleware('auth:sanctum');

Route::patch('/change-password', [ChangePasswordController::class, 'update'])->middleware('auth:sanctum');
Route::post('/wallet/cash-in', CashInController::class)->middleware('auth:sanctum', 'has_wallet');
Route::any('/wallet/payment-received', PaymentReceivedController::class);
Route::get('/payment/{transaction}', VerifyPaymentController::class)->middleware('auth:sanctum', 'has_wallet');

Route::post('/admins', [AdminController::class, 'createAdmin'])->middleware('auth:sanctum', 'admin');

Route::get('/questions',[QuestionController::class, 'index']);
Route::post('/questions',[QuestionController::class, 'create'])->middleware('auth:sanctum', 'admin');
Route::put('/questions/{id}',[QuestionController::class, 'update'])->middleware('auth:sanctum', 'admin');
Route::post('/questions/{id}',[QuestionController::class, 'show']);
Route::delete('/questions/{id}',[QuestionController::class, 'delete'])->middleware('auth:sanctum', 'admin');
