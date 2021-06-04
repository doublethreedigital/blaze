<?php

use DoubleThreeDigital\Blaze\Http\Controllers\ConfigController;
use DoubleThreeDigital\Blaze\Http\Controllers\BlazeController;
use Illuminate\Support\Facades\Route;

Route::name('blaze.')->prefix('blaze')->group(function () {
    Route::post('/', [BlazeController::class, 'index'])->name('search');
    Route::get('/config', [ConfigController::class, 'index'])->name('config');
});
