<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    User, Admin
};

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

Route::middleware('xendit.callback')->post('topup/callback', [User\TopUpController::class, 'callback']); # Done

Route::prefix('user')->group(function () {
    Route::middleware('guest:user')->group(function () {
        Route::middleware('recaptcha')->group(function () {
            // Auth
            Route::post('login', [User\Auth\LoginController::class, 'login']); # Done
            Route::post('register', [User\Auth\RegisterController::class, 'register']); # Done

            // Password Reset
            Route::post('password/email', [User\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']); # Done
        });

        Route::post('auth/social/{provider}', [User\Auth\SocialiteController::class, 'signInWithSocial']);

        // Verify
        Route::post('email/resend', [User\Auth\VerificationController::class, 'resend']);
        Route::post('email/verify/{user:id?}', [User\Auth\VerificationController::class, 'verify'])->name('verification.verify'); # Done

        // Password Reset
        Route::post('password/token', [User\Auth\ResetPasswordController::class, 'checkToken']); # Done
        Route::post('password/reset', [User\Auth\ResetPasswordController::class, 'reset'])->name('password.reset'); # Done
    });

    Route::middleware('auth:user')->group(function () {
        Route::get('/', [User\UserController::class, 'current']); # Done

        Route::prefix('history')->group(function () {
            Route::get('/', [User\HistoryController::class, 'index']);
            Route::get('/{id}', [User\HistoryController::class, 'show']);
        });

        Route::post('avatar', [User\AvatarController::class, 'upload']); # Done
        Route::post('logout', [User\Auth\LoginController::class, 'logout']); # Done

        Route::patch('profile', [User\UserController::class, 'update']); # Done
        Route::patch('password', [User\UserController::class, 'updatePassword']); # Done

        Route::prefix('topup')->group(function () {
            Route::get('history', [User\TopUpController::class, 'index']);
            Route::post('create', [User\TopUpController::class, 'create']);
        });

        Route::post('tracking/update', [User\TrackingController::class, 'updateLocation']);

        Route::get('payment', [User\PaymentController::class, 'index']);

        Route::prefix('information')->group(function () {
            Route::get('/', [User\InformationController::class, 'index']); # Done
            Route::get('/{slug}', [User\InformationController::class, 'show']); # Done
        });

        Route::prefix('chat')->group(function () {
            Route::get('user', [User\ChatController::class, 'getUser']);
            Route::apiResource('/', User\ChatController::class)->parameters([ '' => 'chat' ]);
        });

        Route::apiResource('order', User\OrderController::class)->only('store', 'destroy');
        Route::apiResource('product', User\ProductController::class)->only('index', 'show');
    });
});

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::middleware('recaptcha')->group(function () {
            // Auth
            Route::post('login', [Admin\Auth\LoginController::class, 'login']); # Done

            // Password Reset
            Route::post('password/email', [Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']); # Done
        });

        // Password Reset
        Route::post('password/token', [Admin\Auth\ResetPasswordController::class, 'checkToken']); # Done
        Route::post('password/reset', [Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.reset'); # Done
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [Admin\UserController::class, 'current']); # Done
        Route::post('search', [Admin\SearchController::class, 'index']); # Done

        Route::post('avatar', [Admin\AvatarController::class, 'upload']); # Done
        Route::post('logout', [Admin\Auth\LoginController::class, 'logout']); # Done

        Route::patch('profile', [Admin\UserController::class, 'update']); # Done
        Route::patch('password', [Admin\UserController::class, 'updatePassword']); # Done

        Route::prefix('transaction')->group(function () {
            Route::get('history', [Admin\TransactionController::class, 'index']);
            Route::post('agreement', [Admin\TransactionController::class, 'update']);
        });

        Route::prefix('recap')->group(function () {
            Route::get('report', [Admin\HomeController::class, 'report']);

            Route::prefix('chart')->group(function () {
                Route::get('purchase', [Admin\HomeController::class, 'purchase']);
                Route::get('finance', [Admin\HomeController::class, 'incomeExpense']);
            });
        });

        Route::prefix('order')->group(function () {
            Route::get('id/{id}', [Admin\OrderController::class, 'show']);
            Route::post('status', [Admin\OrderController::class, 'orderStatus']);
        });

        Route::post('tracking/update', [Admin\TrackingController::class, 'updateLocation']);

        Route::prefix('product')->group(function () {
            Route::apiResource('/', Admin\ProductController::class)->parameters([ '' => 'product' ]);
            Route::apiResource('stock', Admin\ProductStockController::class)->only('show', 'update');

            Route::patch('status/{id}', [Admin\ProductController::class, 'status']);
        });

        Route::prefix('chat')->group(function () {
            Route::get('user', [Admin\ChatController::class, 'getUser']);
            Route::apiResource('/', Admin\ChatController::class)->parameters([ '' => 'chat' ]);
        });

        Route::apiResources([
            'courier'       => Admin\CourierController::class,
            'member'        => Admin\MemberController::class,
            'vehicle'       => Admin\VehicleController::class,
            'spending'      => Admin\SpendingController::class,
            'information'   => Admin\InformationController::class
        ]);

        Route::prefix('report')->group(function () {
            Route::get('product', [Admin\ProductController::class, 'report']);
            Route::get('transaction', [Admin\TransactionController::class, 'report']);
            Route::get('vehicle', [Admin\VehicleController::class, 'report']);
        });

        Route::prefix('print')->group(function () {
            Route::post('report/transaction', [Admin\TransactionController::class, 'print']);
        });
    });
});
