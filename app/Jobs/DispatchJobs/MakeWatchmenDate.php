<?php

namespace App\Jobs\DispatchJobs;

use App\Models\Course;
use App\Models\Watchman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MakeWatchmenDate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $year;
    private $month;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $year, int $month)
    {
        //
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('--------------------生成' . $this->year . '年' . $this->month . '月值班日期：开始--------------------');
        for ($i = 0; $i < 31; $i++) {
            $date = date_create($this->year . '-' . $this->month);
            $newDate = $date->add(date_interval_create_from_date_string('+' . $i . 'day'));
            //如果增加天数后日期为1，且i不等于0，说明到下个月了，则停止添加了
            if (getdate($date->getTimestamp())['mday'] == 1 && $i != 0) {
                return;
            }
            Watchman::query()->create([
                'date' => $newDate,
                'week' => Watchman::$weekMap[getdate($newDate->getTimestamp())['wday']],
            ]);
        }
        Log::info('--------------------生成' . $this->year . '年' . $this->month . '月值班日期：结束--------------------');
    }
}
