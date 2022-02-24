<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use EasyWeChat\Kernel\Traits\InteractWithConfig;
use EasyWeChat\MiniApp\Application;
use GuzzleHttp\Client;
use Overtrue\Socialite\Providers\WeChat;


class EasyWechatController extends Controller
{
    protected $app;


    public function __construct()
    {

//         $b = base64_encode('tangwanfa');
//         dd($b);
        $this->app = new Application(config('wechat'));
    }

    public function index()
    {
//        phpinfo();
        $oauth = $this->app->getOAuth();
        $redirectUrl = $oauth->scopes(['snsapi_userinfo'])->redirect('http://api.tangaf.top/api/easyWechat/getUser');
        return redirect($redirectUrl);
    }


    public function getUser()
    {
        $oauth = $this->app->getOAuth();
        $code = $_GET['code'];
        $user = $oauth->userFromCode($code);
        return $user->getName();
    }
}
