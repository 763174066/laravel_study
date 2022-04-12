<?php

namespace App\Http\Controllers;

use App\Models\ClassinOldLessonInfo;
use App\Services\EeoService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        return ClassinOldLessonInfo::query()->whereYear('begin_time',2022)->whereMonth('begin_time',1)->count();
    }


}
