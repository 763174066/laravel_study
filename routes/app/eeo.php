<?php

use App\Http\Controllers\Classin\ForeignTeacherController;
use App\Http\Controllers\Classin\GetOldLessonsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'eeo'
], function () {
    Route::post('getOldLessons', [GetOldLessonsController::class, 'getOldLessons'])->name('eeo.getOldLessons');
    Route::post('getVideoUrlExcel', [GetOldLessonsController::class, 'getVideoUrlExcel'])->name('eeo.getVideoUrlExcel');
    Route::get('getForeignTeachers',[ForeignTeacherController::class,'getForeignTeachers']);
});
