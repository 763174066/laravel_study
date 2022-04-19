<?php

namespace App\Http\Controllers;

use App\Models\ClassinOldLessonInfo;
use App\Models\UserModel;
use App\Models\Watchman;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $user = UserModel::query()->first();
        dd(localtime(null,true));
    }


}
