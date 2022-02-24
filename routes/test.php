<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::domain('www.ll.com')->namespace('App\Http\Controllers')->get('test',[TestController::class,'index']);


