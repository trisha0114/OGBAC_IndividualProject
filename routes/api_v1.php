
<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserCustomersController;

// Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected authentication routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Customers belonging to one user
Route::apiResource('users.customers', UserCustomersController::class)
    ->only(['index']);
});

// Customer routes
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{customer}', [CustomerController::class, 'show']);

// Staff routes
Route::get('/staff', [StaffController::class, 'index']);
Route::get('/staff/{user}', [StaffController::class, 'show']);
