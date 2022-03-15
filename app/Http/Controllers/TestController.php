<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Models\ClassinSubscribeMsg;
use App\Models\ClassListener;
use App\Models\Course;
use App\Services\QywxMsgService;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{
    public function index(Request $request)
    {
        dd(today()->month());
    }



}
