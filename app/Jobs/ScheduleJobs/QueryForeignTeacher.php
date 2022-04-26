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

class QueryForeignTeacher implements ShouldQueue
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
        Log::info('--------------获取上线外教：开始--------------');

        $path = '/saasajax/teacher.ajax.php?action=getSchoolTeacherFullList';
        $data = [
            'page' => 1,
            'perpage' => 50,
            'labelIds' => 211873,
            'status' => 0
        ];

        $res = (new EeoService())->eeoRequest($path, $data)->json();
        if ($res['error_info']['errno'] != 1) {
            return;
        }
        if (empty($res['data']['list'])) {
            return;
        }

        foreach ($res['data']['list'] as $item) {
            ForeignTeacher::query()->firstOrCreate([
                'eeo_id' => $item['id']
            ], [
                'eeo_u_id' => $item['uid'],
                'name' => $item['name'],
                'account' => $item['account'],
            ]);
        }

        Log::info('--------------获取上线外教：结束--------------');
    }
}
