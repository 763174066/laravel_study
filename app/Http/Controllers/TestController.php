<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Jobs\ScheduleJobs\LessonWatch;
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
        $startTimestamp = strtotime($dataArr['year'] . '-' . $dataArr['mon'] . '-' . $dataArr['mday'] . ' 00:00:00');
        $endTimestamp = strtotime($dataArr['year'] . '-' . $dataArr['mon'] . '-' . $dataArr['mday'] . ' 23:59:59');
        $data = [
            'page' => 1,
            'pageSize' => 50,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp,
            'classTimeStatus' => '2', //2上课中，1未开始
            'classStatus' => 0,
            'classType' => 1,
            'sort' => 0,
        ];

        $url = config('classin.base_url') . '/saasajax/teaching.ajax.php?action=getClassInfo';
        $res = Http::asForm()->withHeaders(['cookie' => 11])->post($url, $data)->json();

    }


}
