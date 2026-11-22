<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\StaffController;
use App\Http\Controllers\Api\V1\UserCustomersController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

// Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {

    // Authentication
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User management routes
    Route::apiResource('users', UserController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);

    // Replace user using PUT
    Route::put(
        '/users/{user}',
        [UserController::class, 'replace']
    );

    // Customer routes
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);
    Route::put('/customers/{customer}', [CustomerController::class, 'replace']);
    Route::patch('/customers/{customer}', [CustomerController::class, 'update']);

    // Nested user customers routes
    Route::apiResource('users.customers', UserCustomersController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->scoped();

    // Replace customer using PUT
    Route::put(
        '/users/{user}/customers/{customer}',
        [UserCustomersController::class, 'replace']
    )->scopeBindings();
});

// Public customer routes
Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers/{customer}', [CustomerController::class, 'show']);

// Staff routes
Route::get('/staff', [StaffController::class, 'index']);
Route::get('/staff/{user}', [StaffController::class, 'show']);
