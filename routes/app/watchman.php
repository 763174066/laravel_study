<?php

use App\Http\Controllers\Classin\GetOldLessonsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WatchmanController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'watchman'
], function () {
    Route::post('addMonthDate', [WatchmanController::class, 'addMonthDate']);
});
