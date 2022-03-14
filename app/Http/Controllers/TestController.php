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
        $dataArr = getdate();
        $startTimestamp = strtotime($dataArr['year'].'-'.$dataArr['mon'].'-'.$dataArr['mday'].' 06:00:00 +1 day');
        $endTimestamp = strtotime($dataArr['year'].'-'.$dataArr['mon'].'-'.$dataArr['mday'].' 09:00:00 +1 day');

        $data = [
            'page' => 1,
            'pageSize' => 50,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp,
            'classTimeStatus' => '0',
            'classStatus' => 0,
            'classType' => 1,
            'sort' => 0,
        ];

        $msgService = new QywxMsgService();

        $url = config('classin.base_url') . '/saasajax/teaching.ajax.php?action=getClassInfo';
        $res = Http::asForm()->withHeaders(['cookie' => config('classin.cookie')])->post($url, $data)->json();
        dd($res);



        $msgService->sendMsg('明天早上9点钟之前有'.$res['data']['total'].'节课，请值班人员注意');
    }



}
