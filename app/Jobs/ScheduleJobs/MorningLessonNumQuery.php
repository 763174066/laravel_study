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

class MorningLessonNumQuery implements ShouldQueue
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
        $dataArr = getdate();
        $startTimestamp = strtotime($dataArr['year'].'-'.$dataArr['mon'].'-'.$dataArr['mday'].' 06:00:00 +1 day');
        $endTimestamp = strtotime($dataArr['year'].'-'.$dataArr['mon'].'-'.$dataArr['mday'].' 09:00:00 +1 day');

        $data = [
            'page' => 1,
            'pageSize' => 50,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp,
            'classTimeStatus' => '0',
            'classStatus' => 0,
            'classType' => 1,
            'sort' => 0,
        ];

        $msgService = new QywxMsgService();

        $url = config('classin.base_url') . '/saasajax/teaching.ajax.php?action=getClassInfo';
        $res = Http::asForm()->withHeaders(['cookie' => config('classin.cookie')])->post($url, $data)->json();
        $msgService->sendStudentMsg('明天早上9点钟之前有'.$res['data']['total'].'节课，请值班人员注意');
    }
}
