<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function ok(string $message, $data = null): JsonResponse
    {
        return $this->success($message, $data);
    }

    protected function success(
        string $message,
        $data = null,
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    protected function error(
        string $message,
        int $statusCode = 400
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    /**
     * 403 Forbidden: the user is logged in
     * but is not allowed to do this.
     */
    protected function notAuthorized(string $message): JsonResponse
    {
        return $this->error($message, 403);
    }
}
