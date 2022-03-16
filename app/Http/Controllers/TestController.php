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
        $lesson = '仪陇初一6 人教版 L1 lesson - 8';
        $teacher = 'Jack';
        $student = 'Jack';
        $teacherStatus = 1; //1上线，0未上线
        $teacherStatusInfo = $teacherStatus ? '，状态：<font color="info">已上线</font>。' : '，状态：<font color="warning">未上线</font>。';

        $studentStatus = 0;
        $studentPhone = 13368228333;
        $studentStatusInfo = $studentStatus ? '，状态：<font color="info">已上线</font>。' : '，状态：<font color="warning">未上线</font>。联系方式：' . $studentPhone;

        $testBotUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=dcde8c50-c719-4846-b8c1-46a6f55dadbc';
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'content' => '>**课节：**' . $lesson . '
                              >**外教：**' . $teacher . $teacherStatusInfo . '
                              >**中教：**' . $student . $studentStatusInfo
            ]
        ];
        Http::post($testBotUrl, $data);
    }


}
