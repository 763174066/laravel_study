<?php

namespace App\Http\Controllers;

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
        $routes = Route::getRoutes();
        $arr = [];
        foreach ($routes as $route) {
            $p = stripos($route->uri, 'api');
            if ($p === 0) {
                if (!empty($route->action['as'])) {
                    array_push($arr, $route->action['as']);
                }
            }
        }
        return $arr;
    }


}
