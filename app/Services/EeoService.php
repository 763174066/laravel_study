<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;

class EeoService
{
    /**
     * 获取eeo数据
     * @param string $path
     * @param array $data
     * @param string $method
     * @return array|mixed|string
     */
    public function eeoRequest(string $path, array $data, string $method = 'post')
    {
        $url = config('classin.base_url') . $path;

        if ($method == 'post') {
            return Http::asForm()->withHeaders(['cookie' => config('classin.cookie')])->post($url, $data);
        }
        if ($method == 'get') {
            return Http::asForm()->withHeaders(['cookie' => config('classin.cookie')])->get($url, $data);
        }

        return '请求方法错误';
    }


}
