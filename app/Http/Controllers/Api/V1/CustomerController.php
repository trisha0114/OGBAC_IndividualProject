<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\Api\V1\StoreCustomerRequest;
use App\Models\Customer;
use App\Http\Filters\V1\CustomerFilter;

class CustomerController extends APIController
{
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

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create(
            $request->mappedAttributes()
        );

        return new CustomerResource($customer);
    }

    public function show(Customer $customer)
    {
        if ($this->include('user')) {
            $customer->load('user');
        }

        return new CustomerResource($customer);
    }

    /**
     * DELETE /api/v1/customers/{customer}
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return $this->ok('Customer successfully deleted');
    }
}
