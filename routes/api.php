<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/orders/create', [OrdersController::class, 'create']);
    Route::post('/orders/searchById', [OrdersController::class, 'searchById'])->name('searchById');
    Route::post('/orders/getAllOrders', [OrdersController::class, 'getAllOrders'])->name('getAllOrders');
    Route::post('/orders/edit', [OrdersController::class, 'edit'])->name('edit');

});
