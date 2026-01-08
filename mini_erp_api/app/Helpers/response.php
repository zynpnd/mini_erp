<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('apiSuccess')) {
    function apiSuccess($data = null, string $message = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

if (!function_exists('apiError')) {
    function apiError(string $message = 'Bir hata oluştu', int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
