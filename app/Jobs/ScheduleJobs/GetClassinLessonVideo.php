<?php

namespace App\Jobs\ScheduleJobs;

use App\Models\ClassinLessonVideo;
use App\Models\ClassinOldLessonInfo;
use App\Services\EeoService;
use App\Services\QywxMsgService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetClassinLessonVideo implements ShouldQueue
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
        Log::info('-----------------开始获取课节视频链接-----------------');
        $data = ClassinOldLessonInfo::query()
            ->oldest()
            ->limit(100)
            ->where('has_get_download_link', ClassinOldLessonInfo::HAS_GET_DOWNLOAD_LINK_NO)
            ->get();

        if (!empty($data)) {
            foreach ($data as $lessonItem) {
                $postData = [
                    'courseId' => $lessonItem->course_id,
                    'classId' => $lessonItem->lesson_id,
                    'page' => 1,
                    'perpage' => 100,
                ];
                $res = (new EeoService())->eeoRequest('/saasajax/school.ajax.php?action=getClassVodList', $postData);
                $res = json_decode(substr($res->body(), 3), true);//获取视频这里eeo返回的数据在body里面，并且前面有3个奇怪的字符
                if ($res['error_info']['errno'] != 1) {
                    (new QywxMsgService())->sendExceptionMsg('获取视频下载链接错误：' . $res['error_info']['error']);
                    return;
                }
                foreach ($res['data']['VodInfo']['FileList'] as $items) {
                    foreach ($items['Playset'] as $item) {
                        ClassinLessonVideo::query()->firstOrCreate([
                            'url' => $item['Url']
                        ], [
                            'course_id' => $lessonItem->course_id,
                            'lesson_id' => $lessonItem->lesson_id,
                            'course_name' => $lessonItem->course_name,
                            'class_name' => $lessonItem->class_name,
                            'begin_time' => $lessonItem->begin_time,
                        ]);
                    }
                }
                $lessonItem->update(['has_get_download_link' => ClassinOldLessonInfo::HAS_GET_DOWNLOAD_LINK_YES]);
            }
        }
        Log::info('-----------------获取课节视频链接结束-----------------');
    }

    private function getLessons(){
        return ClassinOldLessonInfo::query()
            ->oldest()
            ->limit(10)
            ->where('has_get_download_link', ClassinOldLessonInfo::HAS_GET_DOWNLOAD_LINK_NO)
            ->get();
    }
}
