<?php

namespace App\Http\Controllers\Classin;

use App\Http\Controllers\Controller;
use App\Jobs\DispatchJobs\GetOldLessons;
use App\Models\OldLessonNum;
use App\Services\EeoService;
use App\Services\QywxMsgService;


class GetOldLessonsController extends Controller
{

    public function getOldLessons()
    {
        $params = $this->validateWith([
            'year' => ['int', 'required'],
            'month' => ['int', 'required'],
        ]);
        $data = $this->getOldLessonsNum($params['year'], $params['month']);
        GetOldLessons::dispatch($data);
    }

    /**
     * 获取指定月份的课节数量，总页数，当前下载页
     * @param $year
     * @param $month
     * @return false
     */
    private function getOldLessonsNum($year, $month)
    {
        $startTime = strtotime($year . '-' . $month . '-1');
        $endTime = strtotime($year . '-' . $month . '-1 +1 month');
        $data = OldLessonNum::query()->where('year', $year)->where('month', $month)->first();
        if (empty($data)) {
            $data = [
                'page' => 1,
                'perpage' => 1,
                'classStatus' => 3,
                'sort' => json_encode([
                    'sortName' => 'classBtime',
                    'sortValue' => 2
                ]),
                'timeRange' => json_encode([
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                ]),
            ];

            $res = (new EeoService())->eeoRequest('/saasajax/course.ajax.php?action=getClassList', $data);
            $res = $res->json();
            if ($res['error_info']['errno'] != 1) {
                (new QywxMsgService())->sendExceptionMsg($res['error_info']['error']);
                return false;
            }
            $totalPage = ceil($res['data']['totalClassNum'] / 100);

            $data = OldLessonNum::query()->create([
                'year' => $year,
                'month' => $month,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'num' => $res['data']['totalClassNum'],
                'total_page' => $totalPage,
            ]);
        }
        return $data;
    }


}
