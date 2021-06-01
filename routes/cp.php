<?php

use DoubleThreeDigital\Zippy\Http\Controllers\ZippyController;
use Illuminate\Support\Facades\Route;

Route::post('/zippy', [ZippyController::class, 'index'])->name('zippy');
