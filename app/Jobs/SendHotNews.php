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

class SendHotNews implements ShouldQueue
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
        $res = Http::get('http://api.tianapi.com/networkhot/index?key=140d822a50fe8ec17b1a31d9f6114ea6');
        $data = $res->json();
        if ($data['code'] != 200) {
            return;
        }
        $str = '';
        foreach ($data['newslist'] as $item) {
            $str .= ("#### " . $item['title'] . "
            ");
        }

        $params = [
            'msgtype' => 'markdown',
            'markdown' => [
                'content' => " **3分钟了解国内外要闻**
                " . $str
            ]
        ];

        Http::asJson()->post(config('qywx.com'), $params);
    }
}
