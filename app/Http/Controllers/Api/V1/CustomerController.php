<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;

class CustomerController extends APIController
{
    /**
     * GET /api/v1/customers
     */
    public function index()
    {
        if ($this->include('user')) {
            return CustomerResource::collection(
                Customer::with('user')->paginate(15)
            );
        }

        return CustomerResource::collection(
            Customer::paginate(15)
        );
    }

    /**
     * GET /api/v1/customers/{customer}
     */
    public function show(Customer $customer)
    {
        if ($this->include('user')) {
            return new CustomerResource(
                $customer->load('user')
            );
        }

        return new CustomerResource($customer);
    }
}
