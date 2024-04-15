<?php

use App\Http\Controllers\QuoteController;
use App\Http\Middleware\AuthApiMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([AuthApiMiddleware::class])->group(function () {
    Route::get('quotes', [QuoteController::class, 'get']);
    Route::get('quotes/refresh', [QuoteController::class, 'refresh']);
});
