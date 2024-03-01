<?php

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

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/token', [App\Http\Controllers\Api\AuthController::class, 'getAccessToken']);


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {

    Route::post('/generate-wallet', [App\Http\Controllers\Api\WalletController::class, 'generateWallet']);
    Route::post('/all-transactions', [App\Http\Controllers\Api\TransactionController::class, 'get_all_transactions']);
    Route::post('/transaction', [App\Http\Controllers\Api\TransactionController::class, 'getSpecificCoinTransactions']);
    Route::post('/transfer', [App\Http\Controllers\Api\TransferController::class, 'transferFunds']);
    Route::post('/balance', [App\Http\Controllers\Api\BalanceController::class, 'getBalance']);
    Route::post('/wallets', [App\Http\Controllers\Api\BalanceController::class, 'all_Balance']);
});
