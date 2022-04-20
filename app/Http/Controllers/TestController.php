<?php

namespace App\Http\Controllers;

use App\Models\ClassinOldLessonInfo;
use App\Models\UserModel;
use App\Models\Watchman;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $user = UserModel::query()->where('username','admin')->first();
//        $has = $user->hasPermissionTo('watchman.addMonthDate');

//        dd( $user->can('watchman.index'));
        dd( $user->can('watchman.addMonthDate'));
    }


}
