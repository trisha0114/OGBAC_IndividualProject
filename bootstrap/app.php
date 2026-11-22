<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            return $request->is('api/*') ? null : route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (
            Throwable $exception,
            Request $request
        ): ?JsonResponse {
            if (!$request->is('api/*') && !$request->expectsJson()) {
                return null;
            }

            if ($exception instanceof ValidationException) {
                $errors = [];

                foreach ($exception->errors() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errors[] = [
                            'status' => 422,
                            'message' => $message,
                            'source' => $field,
                        ];
                    }
                }

                return response()->json([
                    'errors' => $errors,
                ], 422);
            }

            $status = match (true) {
                $exception instanceof AuthenticationException => 401,
                $exception instanceof AuthorizationException => 403,
                $exception instanceof ModelNotFoundException => 404,
                $exception instanceof HttpExceptionInterface =>
                    $exception->getStatusCode(),
                default => 500,
            };

            $message = match ($status) {
                401 => 'Unauthenticated.',
                403 => 'Forbidden.',
                404 => 'Resource not found.',
                405 => 'Method not allowed.',
                default => $status >= 500
                    ? 'Internal server error.'
                    : 'Request failed.',
            };

            return response()->json([
                'errors' => [
                    [
                        'status' => $status,
                        'message' => $message,
                        'source' => '',
                    ],
                ],
            ], $status);
        });
    })->create();
