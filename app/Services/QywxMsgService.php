<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;

class QywxMsgService
{

    private $jsbUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=629e561c-baee-4321-8f43-93867edadf10';

    private $comLessonWatchBotUrl = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=58c425f7-9152-42b6-b64d-fd4880c77a02';

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
        return Http::post($this->jsbUrl,$data)->json();
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
