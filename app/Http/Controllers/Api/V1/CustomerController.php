<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use App\Http\Filters\V1\CustomerFilter;

class CustomerController extends APIController
{
    /**
     * GET /api/v1/customers
     * Supports filtering and optional user relationship.
     */
    public function index(CustomerFilter $filters)
    {
        $customers = Customer::filter($filters);

        if ($this->include('user')) {
            $customers->with('user');
        }

        return CustomerResource::collection(
            $customers->paginate(15)
        );
    }

    /**
     * GET /api/v1/customers/{customer}
     */
    public function show(Customer $customer)
    {
        if ($this->include('user')) {
            $customer->load('user');
        }

        return new CustomerResource($customer);
    }
}
