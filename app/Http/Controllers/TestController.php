<?php

namespace App\Http\Controllers;

use App\Jobs\MyJob;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(Request $request)
    {
//        GetOldLessons::dispatch();
        MyJob::dispatch();
    }


}
