<?php

use App\Http\Controllers\{ User, Admin };

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

Route::get('topup/callback/{status}', [User\TopUpController::class, 'handleCallback']);

Route::prefix('cronjob')->group(function () {
    Route::get('bill', [Admin\SpendingController::class, 'bill']);
});
