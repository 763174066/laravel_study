<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'course'
], function () {
    Route::any('getCourse', [CourseController::class, 'getCourse']);
});
