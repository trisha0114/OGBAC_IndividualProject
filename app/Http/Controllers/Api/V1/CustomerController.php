<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\ApiResponses;

class CustomerController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $customers = Customer::all();

        return $this->success(
            'Customers retrieved successfully',
            $customers
        );
    }
}