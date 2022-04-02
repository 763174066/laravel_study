<?php

namespace App\Jobs\DispatchJobs;

use App\Models\ClassinOldLessonInfo;
use App\Models\Course;
use App\Models\OldLessonNum;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetOldLessons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $path = '/saasajax/course.ajax.php?action=getClassList';

    public $timeout = 300;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OldLessonNum $data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('-----------------开始获取课节-----------------');

        for ($page = $this->data->page; $page <= $this->data->total_page; $page++) {
            Log::info('第' . $page . '页开始获取');
            $res = (new EeoService())->eeoRequest($this->path, $this->eeoData($page));
            $res = $res->json();
            if ($res['error_info']['errno'] != 1) {
                (new QywxMsgService())->sendExceptionMsg('GetOldLessons队列任务：' . $res['error_info']['error']);
                return;
            }
            foreach ($res['data']['classList'] as $item) {
                ClassinOldLessonInfo::query()->firstOrCreate([
                    'lesson_id' => $item['id']
                ], [
                    'course_id' => $item['courseId'],
                    'course_name' => $item['courseName'],
                    'class_name' => $item['className'],
                    'begin_time' => $item['classBtime'],
                    'end_time' => $item['classEtime'],
                ]);
            }
            $this->data->increment('page');
            Log::info('第' . $page . '页获取完成');
        }
        Log::info('-----------------获取课节结束-----------------');
    }

    /**
     * 请求数据
     * @param $page
     * @return array
     */
    private function eeoData($page)
    {
        return [
            'page' => $page,
            'perpage' => $this->data->per_page,
            'classStatus' => 3,
            'sort' => json_encode([
                'sortName' => 'classBtime',
                'sortValue' => 2
            ]),
            'timeRange' => json_encode([
                'startTime' => $this->data->start_time,
                'endTime' => $this->data->end_time,
            ]),
        ];
    }
}
