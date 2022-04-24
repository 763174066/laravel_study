<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::group([
    'middleware' => 'auth:app',
], function () {
    $files = File::allFiles(__DIR__ . '/app');
    foreach ($files as $file) {
        if ($file->getExtension() == 'php') {
            require_once $file;
        };
    }
});