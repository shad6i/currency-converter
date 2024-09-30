<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->as('integrations.')->group(function () {
    Route::get('currencies', [App\Http\Controllers\Admin\CurrencyController::class, 'index'])->name('admin.currencies.index');
});

