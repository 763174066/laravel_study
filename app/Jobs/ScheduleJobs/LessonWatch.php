<?php

namespace App\Jobs\ScheduleJobs;

use App\Models\ClassListener;
use App\Services\QywxMsgService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Utils;

class LessonWatch implements ShouldQueue
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
        Log::info('--------------开始监课--------------');
        $dataArr = getdate();

        $startTimestamp = strtotime($dataArr['year'] . '-' . $dataArr['mon'] . '-' . $dataArr['mday'] . ' 00:00:00');
        $endTimestamp = strtotime($dataArr['year'] . '-' . $dataArr['mon'] . '-' . $dataArr['mday'] . ' 23:59:59');

        $data = [
            'page' => 1,
            'pageSize' => 50,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp,
            'classTimeStatus' => '2', //2上课中，1未开始
            'classStatus' => 0,
            'classType' => 1,
            'sort' => 0,
        ];

        $msgService = new QywxMsgService();

        $url = config('Classin.base_url') . '/saasajax/teaching.ajax.php?action=getClassInfo';
        $res = Http::asForm()->withHeaders(['cookie' => config('Classin.cookie')])->post($url, $data)->json();

        if($res['error_info']['errno'] != 1){
            $msgService->sendStudentMsg($res['error_info']['error']);
        }

        if (!empty($res['data']['html'])) {
            foreach ($res['data']['html'] as $lesson) {
                //课节名称不包含Lesson，表示不是常规课，跳过处理
                if (substr_count($lesson['name'], 'Lesson') == 0) {
                    continue;
                }

                //学生是否在线
                $studentNotInClass = true;

                foreach ($lesson['attendance'] as $item) {
                    if ($item['isInClass'] == 1) {
                        $studentNotInClass = false;
                    }
                    //学生名称
                    $stu = $res['data']['userInfo'][$item['studentUid']]['username'];
                    //学生状态
                    $stuStatus = $item['isInClass'];
                    //学生电话
                    $stuPhone = $res['data']['userInfo'][$item['studentUid']]['account'];
                }

                //老师是否在线
                $teacherNotInClass = true;
                if ($lesson['teacherInfo']['isInClass'] == '1') {
                    $teacherNotInClass = false;
                }

                //当学生或者老师有一个不在教室时，记录并发送通知
                if ($studentNotInClass || $teacherNotInClass) {
                    //课节名称
                    $lessonName = $lesson['name'];
                    //外教名称
                    $teacher = $lesson['teacherInfo']['teacherName'];
                    //外教状态
                    $tStatus = $lesson['teacherInfo']['isInClass'];
                    $class = ClassListener::query()->firstOrCreate(
                        ['lesson_key' => $lesson['lessonKey']],
                        [
                            'start_at' => $lesson['hours']['start'],
                            'end_at' => $lesson['hours']['end'],
                            'lesson_info' => json_encode($lesson),
                        ]);
                    //通知次数大于2次，不再通知
                    if($class->notice_times > 1){
                        return;
                    }
                    $msgService->sendWatchInfo($lessonName, $teacher, $tStatus, $stu, $stuStatus, $stuPhone);
                    $class->increment('notice_times');

                }

            }
        }

        Log::info('--------------结束监课--------------');
    }
}
