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

    /**
     * 学生信息发送到技术部群
     * @param string $msg
     * @return array|mixed
     */
    public function sendStudentMsg(string $msg){
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $msg
            ]
        ];
        return Http::post($this->jsbLessonWatchUrl,$data)->json();
    }

    /**
     * 外教信息发送到公司群
     * @param string $msg
     * @return array|mixed
     */
    public function sendTeacherMsg(string $msg){
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $msg
            ]
        ];
        return Http::post($this->comLessonWatchBotUrl,$data)->json();
    }
}
