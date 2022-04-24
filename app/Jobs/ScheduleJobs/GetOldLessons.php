<?php

namespace App\Jobs\ScheduleJobs;

use App\Models\ClassinOldLessonInfo;
use App\Models\OldLessonNum;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetOldLessons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;

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
        Log::info('-----------------开始获取课节信息-----------------');
        $num = OldLessonNum::query()->whereRaw('total_page>=page')->latest()->first();
        if (empty($num)) {
            Log::info('-----------------没有可获取的课节-----------------');
            return;
        }

        Log::info('第' . $num->page . '页开始获取');
        $postData = [
            'page' => $num->page,
            'perpage' => $num->per_page,
            'classStatus' => 3,
            'sort' => json_encode([
                'sortName' => 'classBtime',
                'sortValue' => 2
            ]),
            'timeRange' => json_encode([
                'startTime' => $num->start_time,
                'endTime' => $num->end_time,
            ]),
        ];

        //每次获取1页
        $res = (new EeoService())->eeoRequest('/saasajax/course.ajax.php?action=getClassList', $postData);
        $res = $res->json();
        if ($res['error_info']['errno'] != 1) {
            (new QywxMsgService())->sendExceptionMsg('GetOldLessons队列任务：' . $res['error_info']['error']);
            return;
        }
        //存储课节
        foreach ($res['data']['classList'] as $item) {
            $lesson = ClassinOldLessonInfo::query()->firstOrCreate([
                'lesson_id' => $item['id'],
            ], [
                'course_id' => $item['courseId'],
                'course_name' => $item['courseName'],
                'class_name' => $item['className'],
                'begin_time' => $item['classBtime'],
                'end_time' => $item['classEtime'],
            ]);
            if (empty($lesson)) {
                Log::error('存储失败', $item);
            }
        }
        Log::info('第' . $num->page . '页获取完成');
        //获取完成后，页码加1
        $num->increment('page');

        Log::info('-----------------获取课节结束-----------------');
    }
}
