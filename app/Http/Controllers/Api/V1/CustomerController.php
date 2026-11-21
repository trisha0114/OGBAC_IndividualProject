<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\Api\V1\StoreCustomerRequest;
use App\Http\Requests\Api\V1\ReplaceCustomerRequest;
use App\Http\Requests\Api\V1\UpdateCustomerRequest;
use App\Models\Customer;
use App\Http\Filters\V1\CustomerFilter;

class CustomerController extends APIController
{
    /**
     * GET /api/v1/customers
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
     * POST /api/v1/customers
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create(
            $request->mappedAttributes()
        );

        return new CustomerResource($customer);
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

    /**
     * DELETE /api/v1/customers/{customer}
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return $this->ok('Customer successfully deleted');
    }

    /**
     * PUT /api/v1/customers/{customer}
     */
    public function replace(
        ReplaceCustomerRequest $request,
        Customer $customer
    ) {
        $customer->update(
            $request->mappedAttributes()
        );

        return new CustomerResource($customer);
    }

    /**
     * PATCH /api/v1/customers/{customer}
     * Update only the fields included in the request.
     */
    public function update(
        UpdateCustomerRequest $request,
        Customer $customer
    ) {
        if (!$this->isAble('update', $customer)) {
            return $this->notAuthorized(
                'You are not authorized to update this customer.'
            );
        }

        $customer->update(
            $request->mappedAttributes()
        );

        return new CustomerResource($customer);
    }
}
