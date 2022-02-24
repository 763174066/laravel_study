<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Models\ClassinSubscribeMsg;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Kuaidi100MsgController extends Controller
{
    public function index(Request $request)
    {
        Log::info($request->getContent());
    }

    public function showSubscribeMsg(){
        $data = ClassinSubscribeMsg::query()->paginate(2);
        return ClassinSubscribeMsgCollection::collection($data);
    }
}
