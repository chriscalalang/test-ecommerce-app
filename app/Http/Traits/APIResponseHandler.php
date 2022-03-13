<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait APIResponseHandler
 * @package App\Http\Traits
 */
trait APIResponseHandler
{
    /**
     * @param $api
     * @param $message
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success($api, $message, array $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'api' => $api,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * @param $api
     * @param $message
     * @param int $statusCode
     * @param array $data
     * @return JsonResponse
     */
    public function error($api, $message, int $statusCode = 400, array $data = []): JsonResponse
    {
        return response()->json([
            'api' => $api,
            'message' => $message,
            'errors' => $data
        ], $statusCode);
    }

}
