<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * GET /api/v1/customers
     * Returns a paginated list of customers.
     */
    public function index()
    {
        return CustomerResource::collection(
            Customer::paginate(15)
        );
    }

    /**
     * GET /api/v1/customers/{customer}
     * Returns one customer.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }
}