<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/transaction', [TransactionController::class, 'index']);
// Route::get('/transaction/{id}', [TransactionController::class, 'show']);
// Route::post('/transaction', [TransactionController::class, 'store']);
// Route::put('/transaction/{id}', [TransactionController::class, 'update']);
// Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

Route::resource('/transaction', TransactionController::class);
Route::resource('/product', ProductController::class);