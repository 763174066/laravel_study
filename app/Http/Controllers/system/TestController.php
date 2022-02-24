<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Models\ClassinSubscribeMsg;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{
    public function index(Request $request)
    {
        Log::emergency('紧急通知');
    }

}
