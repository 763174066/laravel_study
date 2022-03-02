<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Models\ClassinSubscribeMsg;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{
    public function index(Request $request)
    {
        $res = Http::get('http://api.tianapi.com/networkhot/index?key='.'140d822a50fe8ec17b1a31d9f6114ea6');
        dd($res->json());
    }

}
