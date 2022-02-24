<?php

use App\Http\Controllers\system\ExpressController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'system/express'
], function () {
    Route::get('list', [ExpressController::class, 'index']);
    Route::post('queryExpress/{id}', [ExpressController::class, 'queryExpress']);
    Route::post('store', [ExpressController::class, 'store']);
    Route::post('searchExpressCom', [ExpressController::class, 'searchExpressCom']);
    Route::post('handleExpressCom/{id}', [ExpressController::class, 'handleExpressCom']);
    Route::post('importExpressCom', [ExpressController::class, 'importExpressCom']);
    Route::get('expressComList', [ExpressController::class, 'expressComList']);
});
