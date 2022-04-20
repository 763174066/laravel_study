<?php

use App\Http\Controllers\Classin\GetOldLessonsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WatchmanController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'watchman',
    'middleware' => ['check.permission']
], function () {
    Route::get('index', [WatchmanController::class, 'index'])->name('watchman.index');
    Route::post('addMonthDate', [WatchmanController::class, 'addMonthDate'])->name('watchman.addMonthDate');
    Route::post('test', [WatchmanController::class, 'test'])->name('watchman.test');
});
