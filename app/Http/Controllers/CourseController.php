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


class CourseController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'page' => 1,
            'perpage' => 50,
            'classStatus' => '1,2',
            'sort' => json_encode([
                'sortName' => 'classBtime',
                'sortValue' => 1,
            ]),
            'timeRange' => json_encode([
                'startTime' => 1646064000,
                'endTime' => 1653926399
            ])
        ];
        $cookie = 'UM_distinctid=17dd7eff3604b6-0fceaad82bb47f-6a56772b-384000-17dd7eff3611111; sensorsdata2015jssdkcross=%7B%22distinct_id%22%3A%226696878%22%2C%22first_id%22%3A%2217dd2ef2b2f2f3-0e18e614f2677e-6a56772b-3686400-17dd2ef2b3055d%22%2C%22props%22%3A%7B%22%24latest_traffic_source_type%22%3A%22%E7%9B%B4%E6%8E%A5%E6%B5%81%E9%87%8F%22%2C%22%24latest_search_keyword%22%3A%22%E6%9C%AA%E5%8F%96%E5%88%B0%E5%80%BC_%E7%9B%B4%E6%8E%A5%E6%89%93%E5%BC%80%22%2C%22%24latest_referrer%22%3A%22%22%7D%2C%22%24device_id%22%3A%2217dd2ef2b2f2f3-0e18e614f2677e-6a56772b-3686400-17dd2ef2b3055d%22%7D; _eeos_uid=6696878; _eeos_useraccount=13527449053; _eeos_username=6696878; _eeos_userlogo=%2Fimages%2Fuser.png; _eeos_domain=.eeo.cn; _eeos_remember=1; _eeos_sub=1; _eeos_sid=2727806; _eeos_nsid=Vkc%2BKfzsjN%2FyYQtIddZXSg%3D%3D; PHPSESSID=4k6nghp5pnlclun8oop717lfu4; CNZZDATA1256793290=1798385294-1639998077-https%253A%252F%252Fwww.eeo.cn%252F%7C1646137572; eeo_globalConfig_listPerpage=50; _eeos_traffic=KW8CR4WcOk7yHAJHSkDuiyPXuUfMtvIxHTNYkdpen5yWO8YxHGCFt7JEEq1MthKN3Nvh%2BRpF8CqsQ1FXmTPzVWuWydbsRQV0ePbNhVHK%2BOk%3D; __tk_id=03b2d86dde7e144575638f02ea950359';
        $res = Http::withHeaders([
            'cookie' => $cookie,
//            'content-type' => 'application/x-www-form-urlencoded'
        ])->asForm()->post('https://console.eeo.cn/saasajax/course.ajax.php?action=getClassList', $params);
        $data = $res->json();
        if (!empty($data['data']['classList'])) {
            foreach ($data['data']['classList'] as $item) {
                Course::query()->firstOrCreate(['course_id' => $item['courseId'], 'course_name' => $item['courseName']]);
            }
        }
    }

    /**
     * 获取课程
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getCourse()
    {
        $params = $this->validateWith([
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
        ]);

        $data = [
            'page' => 1,
            'perpage' => 100,
            'courseState' => 1,
        ];

        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $data['timeRange'] = json_encode([
                'startTime' => strtotime($params['start_time']),
                'endTime' => strtotime($params['end_time']),
            ]);
        }

        $res = GetCourse::dispatch($data);
        dd($res);
    }
}
