<?php

namespace App\Http\Controllers;

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

        $res = Http::get('http://api.tianapi.com/networkhot/index?key=140d822a50fe8ec17b1a31d9f6114ea6');

        $data = $res->json();
//        dd($data);
        if ($data['code'] != 200) {
            return;
        }
//        dd($data);
        $str = '';
        foreach ($data['newslist'] as $item) {
            $str .= '#####' . $item['title'];
        }

        $params = [
            'msgtype' => 'markdown',
            'markdown' => [
                'content' => $str
            ]
        ];
        dd($params);
        $res = Http::post(config('qywx.jsb'), $params);
        dd($res->json());
    }

}
