<?php

use App\Http\Controllers\Classin\GetOldLessonsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'eeo'
], function () {
    Route::post('getOldLessons', [GetOldLessonsController::class, 'getOldLessons']);
    Route::post('getVideoUrlExcel', [GetOldLessonsController::class, 'getVideoUrlExcel']);
});
