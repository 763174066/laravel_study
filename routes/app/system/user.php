<?php

use App\Http\Controllers\system\ExpressController;
use App\Http\Controllers\system\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'system/user'
], function () {
    Route::post('addUser', [UserController::class, 'store'])->name('system.user.addUser');
    Route::get('index', [UserController::class, 'index'])->name('system.user.index');
});
