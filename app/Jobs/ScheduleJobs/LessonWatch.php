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
            'classTimeStatus' => '2',
            'classStatus' => 0,
            'classType' => 1,
            'sort' => 0,
        ];

        $msgService = new QywxMsgService();

        $url = config('classin.base_url') . '/saasajax/teaching.ajax.php?action=getClassInfo';
        $res = Http::asForm()->withHeaders(['cookie' => config('classin.cookie')])->post($url, $data)->json();
        if (!empty($res['data']['html'])) {
            foreach ($res['data']['html'] as $lesson) {

                //学生是否在线
                $studentNotInClass = true;
                foreach ($lesson['attendance'] as $item) {
                    if ($item['isInClass'] == 1) {
                        $studentNotInClass = false;
                    }
                }
                //如果当前时间大于开课时间30秒，并且学生不在教室
                if ((time() - $lesson['hours']['start']) > 30 && $studentNotInClass) {
                    $class = ClassListener::query()->firstOrCreate(
                        ['lesson_key' => $lesson['lessonKey']],
                        [
                            'start_at' => $lesson['hours']['start'],
                            'end_at' => $lesson['hours']['end'],
                            'lesson_info' => json_encode($lesson),
                        ]);
                    if ($class->student_late_notice_times <= 2) {
                        //通知3次后停止通知
                        $class->increment('student_late_notice_times');
                        $msgService->sendStudentMsg($lesson['name'] . '##学生未上线，请检查');
                    }
                }

                //老师是否在线
                $teacherNotInClass = true;
                if ($lesson['teacherInfo']['isInClass'] == '1') {
                    $teacherNotInClass = false;
                }

                //如果当前时间大于开课时间30秒，并且老师不在教室
                if ((time() - $lesson['hours']['start']) > 30 && $teacherNotInClass) {
                    $class = ClassListener::query()->firstOrCreate(['lesson_key' => $lesson['lessonKey'],], [
                        'start_at' => $lesson['hours']['start'],
                        'end_at' => $lesson['hours']['end'],
                        'lesson_info' => json_encode($lesson),
                    ]);
                    if ($class->teacher_late_notice_times <= 2) {
                        //通知3次后停止通知
                        $class->increment('teacher_late_notice_times');
                        $msgService->sendTeacherMsg($lesson['name'] . '##外教:'.$lesson['teacherInfo']['teacherName'].'未上线，请检查');
                    }
                }
            }
        }

        Log::info('--------------结束监课--------------');
    }
}
