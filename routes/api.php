<?php

use App\API\Auth\Controllers\AuthAPIController;
use App\API\Cart\Controllers\CartAPIController;
use App\API\Order\Controllers\CheckoutAPIController;
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

Route::post('login', [AuthAPIController::class, 'login'])->name('api.auth.login');


Route::group(['middleware' => ['jwt.auth', 'verified']], function() {
    Route::controller(CartAPIController::class)->group(function () {
        Route::get('carts', 'index');
        Route::post('carts', 'store');
    });
});

Route::post('orders', [CheckoutAPIController::class, 'checkout']);
