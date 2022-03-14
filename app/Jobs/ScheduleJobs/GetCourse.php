<?php

namespace App\Jobs\ScheduleJobs;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetCourse implements ShouldQueue
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
        $data = [
            'page' => 1,
            'perpage' => 100,
            'courseState' => 1,
        ];
        $url = config('classin.base_url') . '/saasajax/course.ajax.php?action=getCourseList';
        $res = Http::asForm()->withHeaders(['cookie' => config('classin.cookie')])->post($url, $data)->json();
        foreach ($res['data']['courseList'] as $item) {
            Course::query()->firstOrCreate([
                'course_id' => $item['courseId'],
                'course_name' => $item['courseName'],
                'begin_time' => $item['beginTime'],
                'total_class_num' => $item['totalClassNum'],
                'course_info' => $item,
            ]);
        }
    }
}
