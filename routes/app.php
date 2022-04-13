<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\system\ClassinMsgController;
use App\Http\Controllers\system\EasyWechatController;
use App\Http\Controllers\system\Kuaidi100MsgController;
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

//easeWechat
Route::group([
    'prefix' => 'easyWechat',
],function (){
    Route::any('index', [EasyWechatController::class, 'index']);
    Route::any('getUser', [EasyWechatController::class, 'getUser']);
});

//classin消息订阅
Route::group([
    'prefix' => 'Classin'
], function () {
    Route::post('subscribeMsg', [ClassinMsgController::class, 'index']);
    Route::get('subscribeMsg', [ClassinMsgController::class, 'showSubscribeMsg']);
});

//快递100消息订阅
Route::group([
    'prefix' => 'kuaidi100'
], function () {
    Route::post('subscribeMsg', [Kuaidi100MsgController::class, 'index']);

});


