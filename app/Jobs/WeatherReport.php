<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = Http::get('https://devapi.qweather.com/v7/weather/3d?location=101040700&key=0f48cf98e1ff4840b79af3c57e31da69');
        $data = $res->json();
        if ($data['code'] != '200') {
            return;
        }
        $params = [
            'msgtype' => 'text',
            'text' => [
                'content' => '渝北区今日天气：最高温' . $data['daily'][0]['tempMax'] . '度，最低温' . $data['daily'][0]['tempMin'] . '度，大部分时间为' . $data['daily'][0]['textDay'],
            ]
        ];
        Http::post(config('qywx.com'), $params);
    }
}
