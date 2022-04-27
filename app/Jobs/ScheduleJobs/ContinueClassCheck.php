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
        $tomorrowStart = $todayUnix + 86400; //查看的明天开始时间
        $tomorrowEnd = $todayUnix + 86400 + 86399; //查看的明天结束时间
        $content = '明天的外教连堂课，请相关小伙伴注意' . '
        ';
        $hasContent = false; //初始不存在连堂课
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

            //当前老师没有课节
            if (empty($res['data']['teacherClassList'])) {
                continue;
            }

            $classList = $res['data']['teacherClassList']; //课节列表
            foreach ($classList as $item) {
                $nextItem = next($classList); //当前课节的下一个课节
                //如果下一个课节不存在，则跳出本循环
                if (empty($nextItem)) {
                    break;
                }
                //如果当前课节的结束时间 = 下一节课的开始时间，表示是连堂课
                if ($item['classEtime'] == $nextItem['classBtime']) {
                    $dateArr = getdate($item['classEtime']);
                    $minutes = $dateArr['minutes'] == 0 ? '00' : $dateArr['minutes'];
                    //拼接日期
                    $time = $dateArr['year'] . '-' .
                        $dateArr['mon'] . '-' .
                        $dateArr['mday'] . ' ' .
                        $dateArr['hours'] . ':' . $minutes;
                    //拼接企业微信机器人文本类容
                    $preClassName = str_replace('*', '_', $item['className']);  //将*替换为_，防止机器人识别错误
                    $nextClassName = str_replace('*', '_', $nextItem['className']);  //将*替换为_，防止机器人识别错误
                    $content .= $this->getString($teacher->name, $time, $preClassName, $nextClassName);
                    $hasContent = true; //存在连堂课
                }
            }
        }
        //存在连堂课则发送信息到公司群
        if ($hasContent) {
            (new QywxMsgService())->sendContinuousClass($content);
        }

        Log::info('--------------连堂课检查：结束--------------');
    }

    /**
     * 拼接企业微信机器人发送内容
     * @param $ftname
     * @param $time
     * @param $preClass
     * @param $nextClass
     * @return string
     */
    private function getString($ftname, $time, $preClass, $nextClass): string
    {
        return '>**外教：**' . '<font color="warning">' . $ftname . '</font>' . '
                >**时间：**' . $time . '
                >**上一节：**' . $preClass . '
                >**下一节：**' . $nextClass . '
                >**-----------------------**' . '
                 ';
    }
}
