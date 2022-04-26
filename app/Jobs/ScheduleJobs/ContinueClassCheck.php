<?php

namespace App\Jobs\ScheduleJobs;

use App\Models\ClassListener;
use App\Models\ForeignTeacher;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Utils;

class ContinueClassCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;




    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('--------------连堂课检查：开始--------------');

        $path = '/saasajax/teacher.ajax.php?action=getTeacherClassList';
        $teachers = ForeignTeacher::query()->get();
        $nowArr = getdate(time());
        $todayUnix = (strtotime($nowArr['year'] . '-' . $nowArr['mon'] . '-' . $nowArr['mday']));
        $tomorrowStart = $todayUnix + 86400;
        $tomorrowEnd = $todayUnix + 86400 + 86399;
        $content = '明天的外教连堂课，请相关小伙伴注意' . '
        ';
        $hasContent = false;
        foreach ($teachers as $teacher) {
            $data = [
                'stId' => $teacher->eeo_id,
                'page' => 1,
                'perpage' => 50,
                'sort' => json_encode([
                    'sortName' => 'classBtime',
                    'sortValue' => 1,
                ]),
                'timeRange' => json_encode([
                    'startTime' => $tomorrowStart,
                    'endTime' => $tomorrowEnd,
                ]),
            ];
            $res = (new EeoService())->eeoRequest($path, $data)->json();
            if (empty($res['data']['teacherClassList'])) {
                continue;
            }
            $classes = $res['data']['teacherClassList'];
            foreach ($classes as $item) {
                $nextItem = next($classes);
                if (empty($nextItem)) {
                    break;
                }
                if ($item['classEtime'] == $nextItem['classBtime']) {
                    $dateArr = getdate($item['classEtime']);

                    $minutes = $dateArr['minutes'] == 0 ? '00' : $dateArr['minutes'];
                    $time = $dateArr['year'] . '-' .
                        $dateArr['mon'] . '-' .
                        $dateArr['mday'] . ' ' .
                        $dateArr['hours'] . ':' . $minutes;
                    $content .= $this->getString($teacher->name, $time, $item['className'], $nextItem['className']);
                    $hasContent = true;
                }
            }
        }
        if ($hasContent) {
//            (new QywxMsgService())->sendContinuousClass($content);
            Log::info($content);
        }

        Log::info('--------------连堂课检查：结束--------------');
    }

    private function getString($ftname, $time, $preClass, $nextClass)
    {
        return '>**外教：**' . '<font color="warning">' . $ftname . '</font>' . '
                >**时间：**' . $time . '
                >**上一节：**' . $preClass . '
                >**下一节：**' . $nextClass . '
                >**-----------------------**' . '
                 ';
    }
}
