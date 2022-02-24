<?php

namespace App\Support\Http;

use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;


class ResponseFactory
{
    /**
     * 200 OK
     *
     * @param mixed $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($data = null, array $headers = [])
    {
        if (!$data) {
            return response()->make('', 200, $headers);
        }

        if (!$data instanceof JsonResource) {
            $data = JsonResource::make($data);
        }

        return $data->response()->withHeaders($headers);
    }

    /**
     * 201 Created
     *
     * @param mixed $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($data = null, array $headers = [])
    {
        if (!$data) {
            return response()->make('', 201, $headers);
        }

        if (!$data instanceof JsonResource) {
            $data = JsonResource::make($data);
        }

        return $data->response()->withHeaders($headers);
    }

    /**
     * 204 No Content
     *
     * @param array $headers
     * @return \Illuminate\Http\Response
     */
    public function noContent($headers = [])
    {
        return response()->noContent(204, $headers);
    }

    /**
     * 401 Unauthorized
     *
     * @param string $message
     * @param array $additional
     * @param array $headers
     * @return void
     */
    public function unauthorized($message = 'Unauthorized', array $additional = [], array $headers = [])
    {
        $this->error(401, $message, $additional, $headers);
    }

    /**
     * 403 Forbidden
     *
     * @param string $message
     * @param array $additional
     * @param array $headers
     * @return void
     */
    public function forbidden($message = 'Forbidden', array $additional = [], array $headers = [])
    {
        $this->error(403, $message, $additional, $headers);
    }

    /**
     * 404 Not Found
     *
     * @param string $message
     * @param array $additional
     * @param array $headers
     * @return void
     */
    public function notFound($message = 'Not Found', array $additional = [], array $headers = [])
    {
        $this->error(404, $message, $additional, $headers);
    }

    /**
     * 422 Unprocessable Entity
     *
     * @param string $message
     * @param array $additional
     * @param array $headers
     * @return void
     */
    public function unprocessableEntity($message = 'Unprocessable Entity', array $additional = [], array $headers = [])
    {
        $this->error(422, $message, $additional, $headers);
    }

    /**
     * 500 Internal Server Error
     *
     * @param string $message
     * @param array $additional
     * @param array $headers
     * @param \Throwable $previous
     * @return void
     */
    public function internalServerError($message = 'Internal Server Error', array $additional = [], array $headers = [], Throwable $previous = null)
    {
        if ($previous) {
            report($previous);
        }

        $this->error(500, $message, $additional, $headers);
    }

    /**
     * 返回一个Http Error
     *
     * @param int $statusCode
     * @param string $message
     * @param array $additional
     * @param array $headers
     * @param \Throwable $previous
     * @return void
     */
    public function error(int $statusCode, string $message, array $additional = [], array $headers = [], Throwable $previous = null)
    {
        throw new HttpException($statusCode, $message, $additional, $headers, $previous);
    }
}
