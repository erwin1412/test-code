<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Format respons API yang dipakai seluruh endpoint:
 *   sukses: { "success": true,  "message": "...", "data": ... }
 *   gagal:  { "success": false, "message": "...", "errors": { ... } }
 */
class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        if ($data instanceof ResourceCollection) {
            $payload = $data->response()->getData(true);

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $payload['data'],
                'meta' => $payload['meta'] ?? null,
            ], $status);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => (object) $errors,
        ], $status);
    }
}
