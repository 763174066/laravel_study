<?php

use App\Http\Controllers\system\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'test'
], function () {
    Route::any('test', [TestController::class, 'index']);
});
