<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\StaffController;
use App\Http\Controllers\Api\V1\UserCustomersController;
use Illuminate\Support\Facades\Route;

// Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected authentication routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Delete customer
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);

    // Replace customer using PUT
    Route::put('/customers/{customer}', [CustomerController::class, 'replace']);

    // Update customer using PATCH (partial update)
Route::patch('/customers/{customer}', [CustomerController::class, 'update']);

    // Customers belonging to one user
    Route::apiResource('users.customers', UserCustomersController::class)
        ->only(['index']);
});

// Customer routes
Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers/{customer}', [CustomerController::class, 'show']);

// Staff routes
Route::get('/staff', [StaffController::class, 'index']);
Route::get('/staff/{user}', [StaffController::class, 'show']);
