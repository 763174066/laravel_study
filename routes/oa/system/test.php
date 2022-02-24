<?php

use App\Http\Controllers\system\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'system/test'
], function () {
    Route::any('index', [TestController::class, 'index']);
});
