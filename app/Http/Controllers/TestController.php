<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Models\ClassinOldLessonInfo;
use App\Models\UserModel;
use App\Models\Watchman;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $res = event(new TestEvent(auth()->user()));
        dd(111);
        dd($res);

    }


}
