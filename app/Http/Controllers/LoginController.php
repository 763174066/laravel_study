<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    //
    public function login()
    {
        $params = $this->validateWith([
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6']
        ]);

        $RedisUsername = 'login.username.' . $params['username'];

//        dd(Redis::ttl($RedisUsername));

        //登录次数检测
        if (Redis::get($RedisUsername) >= config('login.loginErrorTimes')) {
            return $this->response->unauthorized('账号密码错误次数太多，请稍后再登录');
        }

        $user = UserModel::where('username', $params['username'])->first();

        if (!auth('oa')->attempt($params) || !$user) {

            //密码错误时，登录次数+1
            $loginErrorTimes = Redis::get($RedisUsername) ?? 0;
            Redis::setex($RedisUsername, config('login.loginLimitTime'), ++$loginErrorTimes);

            return $this->response->unauthorized('账号或者密码错误');
        }

        auth('oa')->login($user);

        return $this->response->ok($user);
    }

    public function logout()
    {
        auth('oa')->logout();
        return $this->response->ok(['msg' => '退出登录']);
    }
}
