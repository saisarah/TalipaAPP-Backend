<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\CropController;
use App\Http\Controllers\API\DemandController;
use App\Http\Controllers\API\FarmerController;
use App\Http\Controllers\API\FarmerGroupController;
use App\Http\Controllers\API\FarmerGroupMemberController;
use App\Http\Controllers\API\FarmerGroupPostController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\Payment\CashInBuxController;
use App\Http\Controllers\API\Payment\CashInPaymongoController;
use App\Http\Controllers\API\Payment\CashInPaypalController;
use App\Http\Controllers\API\Payment\VerifyPaymentController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ThreadController;
use App\Http\Controllers\API\TransportifyController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VendorController;
use Illuminate\Support\Facades\Broadcast;
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

Broadcast::routes(['middleware' => 'auth:sanctum']);

Route::controller(LoginController::class)->group(function () {
    Route::post('/login/send-otp', 'sendOtp');
    Route::post('/login/verify-otp', 'verifyOtp');
    Route::post('/login', 'login');
    Route::post('/admin-login', 'loginAdmin');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'sendOtp');
    Route::post('/forgot-password/verify', 'verifyOtp');
    Route::patch('/forgot-password/reset', 'resetPassword');
});

Route::controller(RegisterController::class)->group(function () {
    Route::post('/register/vendor', 'registerVendor');
    Route::post('/register/farmer', 'registerFarmer');
    Route::post('/register/validator', 'validator');
    Route::post('/register/send-otp', 'sendOtp');
});

Route::controller(CropController::class)->group(function () {
    Route::get('/crops', 'index');
    Route::post('/crops', 'create')->middleware('admin');
    Route::put('/crops/{id}', 'update')->middleware('admin');
    Route::get('/crops/demands', 'demands');
});

Route::controller(AddressController::class)->group(function () {
    Route::get('/philippine-addresses/regions', 'regions');
    Route::get('/philippine-addresses/provinces', 'provinces');
    Route::get('/philippine-addresses/cities', 'cities');
    Route::get('/philippine-addresses/barangays', 'barangays');
});

Route::controller(FarmerController::class)->group(function () {
    Route::get('/farmers', 'index');
});

Route::controller(VendorController::class)->group(function () {
    Route::get('/vendors', 'index');
});

Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'index');
    Route::post('/questions/{id}', 'show');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index');
    });

    Route::controller(PostController::class)->group(function () {
        Route::get('/posts', 'index');
        Route::get('/posts/{post}', 'show');
        Route::post('/posts', 'create');
        Route::get('/users/{user}/posts', 'getFromUser');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'getCurrentUser');
        Route::get('/users/search', 'search');
        Route::get('/user/transactions', 'transactions');
        Route::get('/user/balance', 'showBalance')->middleware('has_wallet');
        Route::get('/user/address/complete', 'showCompleteAddress');
        Route::get('/users/{user}', 'show');
        Route::get('/users/{user}/thread', 'thread');
    });

    Route::controller(AddressController::class)->group(function () {
        Route::get('/user/address', 'index');
        Route::put('/user/address', 'update');
    });

    Route::controller(FarmerController::class)->group(function () {
        Route::post('/farmers/{farmer}/approve', 'approve')->middleware('admin');
        Route::post('/farmers/{farmer}/rate', 'rate')->middleware('vendor');
        Route::get('/farmers/{farmer}/reviews', 'review');
    });

    Route::controller(FarmerGroupController::class)->group(function () {
        Route::get('/farmer-groups', 'index');
        Route::get('/farmer-group', 'getCurrentGroup');
        Route::post('/farmer-groups', 'create')->middleware('farmer');
        Route::post('/farmer-groups/members/{id}/accept', 'approved')->middleware('farmer', 'has_group', 'president');
        Route::get('/farmer-groups/invitations', 'invitation')->middleware('farmer');
        Route::get('/farmer-groups/pending-members', 'pendingRequest')->middleware('farmer', 'has_group', 'president');
        Route::get('/farmer-groups/invited-members', 'invitedMembers')->middleware('farmer', 'has_group', 'president');
        Route::get('/farmer-groups/{id}', 'show');
        Route::get('/farmer-group/pending', 'showPendingGroup')->middleware('farmer');
        Route::delete('/farmer-groups/members/{id}/cancel', 'cancel')->middleware('farmer', 'president');
    });


    Route::controller(FarmerGroupPostController::class)->group(function () {
        Route::get('/farmer-group/posts', 'index')->middleware('has_group');
        Route::post('/farmer-group/posts', 'create')->middleware('has_group');
        Route::post('/farmer-group-posts/{id}/comments', 'createComment')->middleware('farmer', 'has_group');
        Route::get('/farmer-group-posts/{id}', 'show')->middleware('farmer', 'has_group');
        Route::get('/farmer-group-posts/{id}/comments', 'comments')->middleware('farmer', 'has_group');
    });

    Route::controller(FarmerGroupMemberController::class)->group(function () {
        Route::post('/farmer-groups/{id}/join', 'join');
        Route::delete('/farmer-groups/{id}/cancel', 'cancel')->middleware('farmer');
        Route::post('/farmer-groups/members/invite', 'invite')->middleware('farmer', 'has_group', 'president');
        Route::post('/farmer-groups/{id}/accept', 'acceptInvitation')->middleware('farmer');
    });

    Route::controller(VendorController::class)->group(function () {
        Route::post('/vendors/{vendor}/approve', 'approve')->middleware('admin');
    });

    Route::controller(DemandController::class)->group(function () {
        Route::post('/demands', 'create')->middleware('vendor');
        Route::get('/demands/{id}', 'show');
        Route::get('/demands', 'index');
    });

    Route::controller(ThreadController::class)->group(function () {
        Route::get('/threads', 'index');
        Route::get('/threads/{thread}', 'show');
        Route::get('/threads/{thread}/messages', 'messages');
        Route::post('/threads/{thread}/messages', 'sendMessage');
        Route::patch('/threads/{thread}/read', 'readMessages');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::get('/orders/{order}', 'show');
        Route::post('/posts/{post}/order', 'create');
        Route::delete('/orders/{id}', 'cancel');
        Route::post('/orders/{id}', 'handleOrder')->middleware('farmer');
        Route::post('/orders/{order}/book-vehicle', 'bookVehicle')->middleware('farmer');
    });

    Route::controller(ChangePasswordController::class)->group(function () {
        Route::patch('/change-password', 'update');
    });

    Route::post('/wallet/cash-in-paymongo', CashInPaymongoController::class)->middleware('has_wallet');
    Route::post('/wallet/cash-in-paypal', CashInPaypalController::class)->middleware('has_wallet');
    Route::post('/wallet/cash-in-bux', CashInBuxController::class)->middleware('has_wallet');

    // Route::controller(PaymentReceivedController::class)->group(function () {
    //     Route::any('/wallet/payment-received');
    // });

    Route::get('/payment/{id}', VerifyPaymentController::class)->middleware('has_wallet');

    Route::controller(AdminController::class)->group(function () {
        Route::post('/admins', 'createAdmin')->middleware('admin');
    });

    Route::controller(QuestionController::class)->group(function () {
        Route::post('/questions', 'create')->middleware('admin');
        Route::put('/questions/{id}', 'update')->middleware('admin');
        Route::delete('/questions/{id}', 'delete')->middleware('admin');
    });

    Route::controller(TransportifyController::class)->group(function () {
        Route::get('/transportify/vehicles', 'vehicles');
        Route::post('/transportify/get-quote', 'getQuote');
        Route::post('/transportify/webhook', 'webhook')->withoutMiddleware('auth:sanctum');
    });
});
