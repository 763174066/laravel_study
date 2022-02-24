<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        return 111333555;
    }

    //
    public function store(Request $request)
    {
        $params = $request->validate([
            'username' => ['required', 'min:3', 'string'],
            'password' => ['required', 'min:6']
        ]);

        //检查用户名是否已存在
        $user = UserModel::where('username', $params['username'])->first();

        if ($user) {
            return $this->response->ok(['msg' => '该用户名已存在']);
        }

        $params['password'] = bcrypt($params['password']);

        $user = UserModel::create($params);

        return $this->response->ok($user);
    }
}
