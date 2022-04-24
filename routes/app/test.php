<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'test',
//    'middleware' => ['check.permission']
], function () {
    Route::any('index', [TestController::class, 'index']);
});
