<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class ExpressService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    //
    public function queryExpress($com,$num)
    {
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $post_data = [];
        $post_data['customer'] = config('kuaidi100.customer');
        $post_data['param'] = json_encode(['com' => $com,'num' => $num]);
        $post_data['sign'] = strtoupper(md5($post_data['param'] . config('kuaidi100.key') . config('kuaidi100.customer')));
        $params = "";
        foreach ($post_data as $k => $v) {
            $params .= "$k=" . urlencode($v) . "&";              //默认UTF-8编码格式
        }
        $post_data = substr($params, 0, -1);

        $request = new Request('POST', config('kuaidi100.url'), $headers, $post_data);
        $res = $this->client->send($request);

        return $res->getBody();
    }


}
