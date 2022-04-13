<?php

namespace App\Http\Controllers;

use App\Models\ClassinOldLessonInfo;
use App\Services\EeoService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        dd(strtotime('2021-2'),strtotime('2021-3')) ;
    }


}
