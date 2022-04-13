<?php

namespace App\Http\Controllers\Classin;

use App\Exports\VideoUrlExport;
use App\Http\Controllers\Controller;
use App\Models\ClassinLessonVideo;
use App\Models\ClassinOldLessonInfo;
use App\Models\OldLessonNum;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Maatwebsite\Excel\Facades\Excel;


class GetOldLessonsController extends Controller
{
    /**
     * 获取指定月份的所有课节
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getOldLessons()
    {
        $params = $this->validateWith([
            'year' => ['int', 'required'],
            'month' => ['int', 'required', 'min:1', 'max:12'],
        ]);

        if (OldLessonNum::query()
            ->where('year', $params['year'])
            ->where('month', $params['month'])
            ->exists()) {
            return $this->response->forbidden('这个月已经读取数据了');
        }

        $data = $this->getOldLessonsNum($params['year'], $params['month']);
        if (empty($data)) {
            $this->response->ok([
                'msg' => '获取失败课节数量失败，请检查'
            ]);
        }
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

    /**
     * 获取指定月份的课节视频链接Excel
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getVideoUrlExcel()
    {
        $params = $this->validateWith([
            'year' => ['required', 'int'],
            'month' => ['required', 'int'],
        ]);

        $hasData = OldLessonNum::query()
            ->where('year', $this->year)
            ->where('month', $this->month)
            ->whereRaw('total_page<page')
            ->exists();
        if (!$hasData) {
            $this->response->forbidden('没有该月份数据');
        }

        return Excel::download(new VideoUrlExport($params['year'], $params['month']), $params['year'] . '-' . $params['month'] . '.xlsx');
    }
}
