<?php
use App\Http\Controllers\Api\CustomerController;

Route::get('/v1/customers', [CustomerController::class, 'index']);