<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SpaController;

/*
|--------------------------------------------------------------------------
| SPA Routes
|--------------------------------------------------------------------------
|
| Here is where you can register SPA routes for your frontend. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "spa" middleware group.
|
*/

Route::get('{path}', SpaController::class)->where('path', '(.*)');
