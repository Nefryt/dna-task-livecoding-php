<?php

use App\Http\Controllers\BackofficeController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'addUser']);
Route::post('/transactions', [PaymentController::class, 'addPayment']);
Route::post('/merchants', [MerchantController::class, 'addMerchant']);

Route::prefix('/backoffice')->group(function () {
    Route::get('/income', [BackofficeController::class, 'getIncome']);
});
