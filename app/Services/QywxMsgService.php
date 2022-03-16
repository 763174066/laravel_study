<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;

class QywxMsgService
{

    private $jsbLessonWatchUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=629e561c-baee-4321-8f43-93867edadf10';

    private $comLessonWatchBotUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=95ef0a15-eed7-4cae-8ba4-f6591aad9770';

    private $jsbTestBotUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=dcde8c50-c719-4846-b8c1-46a6f55dadbc';

    /**
     * 学生信息发送到技术部群
     * @param string $msg
     * @return array|mixed
     */
    public function sendStudentMsg(string $msg)
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $msg
            ]
        ];
        return Http::post($this->jsbLessonWatchUrl, $data)->json();
    }

    /**
     * 外教信息发送到公司群
     * @param string $msg
     * @return array|mixed
     */
    public function sendTeacherMsg(string $msg)
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $msg
            ]
        ];
        return Http::post($this->comLessonWatchBotUrl, $data)->json();
    }

    /**
     * 发送监课信息到公司大群
     * @param $lesson
     * @param $teacher
     * @param $tStatus
     * @param $stu
     * @param $stuStatus
     * @param $stuPhone
     * @return array|mixed
     */
    public function sendWatchInfo($lesson, $teacher, $tStatus, $stu, $stuStatus, $stuPhone)
    {
        $teacherStatusInfo = $tStatus ? '，状态：<font color="info">已上线</font>。' : '，状态：<font color="warning">未上线</font>。';

        $studentStatusInfo = $stuStatus ? '，状态：<font color="info">已上线</font>。' : '，状态：<font color="warning">未上线</font>。
>**电话**：' . $stuPhone;

        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'content' => '>**课节：**' . $lesson . '，已经上课了
                              >**外教：**' . $teacher . $teacherStatusInfo . '
                              >**中教：**' . $stu . $studentStatusInfo
            ]
        ];
        return Http::post($this->comLessonWatchBotUrl, $data)->json();
    }
}
