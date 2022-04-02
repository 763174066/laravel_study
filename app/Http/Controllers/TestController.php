<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Jobs\ScheduleJobs\GetClassinLessonVideo;
use App\Jobs\ScheduleJobs\GetOldLessons;
use App\Jobs\ScheduleJobs\LessonWatch;
use App\Jobs\ScheduleJobs\Test;
use App\Jobs\ScheduleJobs\Test2;
use App\Models\ClassinLessonVideo;
use App\Models\ClassinOldLessonInfo;
use App\Models\ClassinSubscribeMsg;
use App\Models\ClassListener;
use App\Models\Course;
use App\Models\OldLessonNum;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Static_;


class TestController extends Controller
{

    public function index(Request $request)
    {
        GetOldLessons::dispatch();
        Test::dispatch();
        Test2::dispatch();
    }


}
