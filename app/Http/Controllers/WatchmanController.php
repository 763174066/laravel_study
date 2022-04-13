<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassinSubscribeMsgCollection;
use App\Jobs\DispatchJobs\GetCourse;
use App\Jobs\DispatchJobs\MakeWatchmenDate;
use App\Models\ClassinSubscribeMsg;
use App\Models\Course;
use App\Models\Watchman;
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
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addMonthDate()
    {
        $params = $this->validateWith([
            'year' => ['required', 'int'],
            'month' => ['required', 'int', 'min:1', 'max:12'],
        ]);
        $hasDate = Watchman::query()->whereYear('date', $params['year'])->whereMonth('date', $params['month'])->exists();
        if ($hasDate) {
            $this->response->forbidden('该月已生成日期');
        }

        MakeWatchmenDate::dispatch($params['year'], $params['month']);
    }
}
