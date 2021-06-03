<?php

use DoubleThreeDigital\Zippy\Http\Controllers\ConfigController;
use DoubleThreeDigital\Zippy\Http\Controllers\ZippyController;
use Illuminate\Support\Facades\Route;

Route::name('zippy.')->prefix('zippy')->group(function () {
    Route::post('/', [ZippyController::class, 'index'])->name('search');
    Route::get('/config', [ConfigController::class, 'index'])->name('config');
});
