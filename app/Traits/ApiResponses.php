<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    /**
     * Shortcut for a 200 OK response.
     */
    protected function ok(string $message, mixed $data = null): JsonResponse
    {
        return $this->success($message, $data);
    }

    /**
     * Generic success response.
     */
    protected function success(
        string $message,
        mixed $data = null,
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    /**
     * Standard error response.
     *
     * Accepts either:
     * - A plain message string
     * - An array of error objects
     */
    protected function error(
        string|array $errors = [],
        ?int $statusCode = null
    ): JsonResponse {

        // A single error message
        if (is_string($errors)) {
            $statusCode ??= 400;

            return response()->json([
                'message' => $errors,
                'status' => $statusCode,
            ], $statusCode);
        }

        // A list of errors
        $status = $statusCode ?? ($errors[0]['status'] ?? 500);

        // Guard against invalid HTTP status codes
        if ($status < 100 || $status > 599) {
            $status = 500;
        }

        return response()->json([
            'errors' => $errors,
        ], $status);
    }

    /**
     * 403 Forbidden: the user is logged in
     * but is not allowed to do this.
     */
    protected function notAuthorized(string $message): JsonResponse
    {
        return $this->error([
            [
                'status' => 403,
                'message' => $message,
                'source' => '',
            ],
        ]);
    }
}
