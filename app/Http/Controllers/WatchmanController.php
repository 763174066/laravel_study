<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Jobs\DispatchJobs\GetCourse;
use App\Models\ClassinSubscribeMsg;
use App\Models\Course;
use EasyWeChat\MiniApp\Application;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


/**
 * 值班人员控制器
 * Class WatchmanController
 * @package App\Http\Controllers
 */
class WatchmanController extends Controller
{

}
