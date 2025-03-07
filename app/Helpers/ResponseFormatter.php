<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseFormatter
{
    public static function format($code, $message = '', $body = [], $error = [], $pagination = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'body' => $body,
            'error' => $error
        ];

        if ($pagination) {
            $response['pagination'] = $pagination;
        }

        return response()->json($response, $code);
    }
}
