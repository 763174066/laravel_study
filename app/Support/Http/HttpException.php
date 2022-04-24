<?php

namespace App\Support\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;
use Throwable;

class HttpException extends SymfonyHttpException implements Responsable
{
    /**
     * 额外的数据
     *
     * @var array
     */
    protected $additional;

    /**
     * HttpException constructor.
     *
     * @param int $statusCode
     * @param string|null $message
     * @param array $additional
     * @param array $headers
     * @param \Throwable|null $previous
     */
    public function __construct(int $statusCode, string $message = null, array $additional = [], array $headers = [], Throwable $previous = null)
    {
        $this->additional = $additional;

        parent::__construct($statusCode, $message, $previous, $headers);
    }

    /**
     * 转换异常为Response
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        $data = array_merge($this->additional, [
            'message' => $this->getMessage(),
        ]);

        return Response::json($data, $this->getStatusCode(), $this->getHeaders(), JSON_UNESCAPED_UNICODE);
    }
}
