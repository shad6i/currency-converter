<?php

use App\Http\Controllers\Api\CurrencyRateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('currencies', [App\Http\Controllers\Admin\CurrencyController::class, 'index'])->name('admin.currencies.index');
});

Route::prefix('api')->as('api.')->group(function () {
    Route::get('/currency/update', [CurrencyRateController::class, 'updateRates']);
});
