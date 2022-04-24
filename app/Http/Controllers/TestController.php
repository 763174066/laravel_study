<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $res = event(new TestEvent(auth()->user()));
        //git tests
        //git ...
        //...

    }


}
