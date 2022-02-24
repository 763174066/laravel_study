<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Models\ClassinSubscribeMsg;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;


class ClassinMsgController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'TimeStamp' => ['required','int'],
            'SafeKey' => ['required','string'],
        ]);
        $data = $request->all();

        $mySafeKey = md5(config('eeo.eeo_secret').$data['TimeStamp']);

        if($mySafeKey != $data['SafeKey']){
            $this->response->unauthorized('验证失败');
        }

        $data['Data'] = json_encode($data['Data']);

        ClassinSubscribeMsg::create($data);

        $msg = [
            "error_info" => [
                "errno" => 1,
                "error" => "程序正常执行",
            ],
        ];

        return response()->json($msg);
    }

    public function showSubscribeMsg(){
        $data = ClassinSubscribeMsg::query()->paginate(2);
        return ClassinSubscribeMsgCollection::collection($data);
    }
}
