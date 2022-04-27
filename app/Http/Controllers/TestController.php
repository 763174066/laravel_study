<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Services\QywxMsgService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $res = (new QywxMsgService())->sendHealthNotice();
    }


}
