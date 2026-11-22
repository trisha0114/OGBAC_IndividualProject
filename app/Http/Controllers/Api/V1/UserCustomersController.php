<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CustomerFilter;
use App\Http\Requests\Api\V1\ReplaceCustomerRequest;
use App\Http\Requests\Api\V1\StoreCustomerRequest;
use App\Http\Requests\Api\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use App\Models\User;
use App\Permissions\V1\Abilities;

class UserCustomersController extends APIController
{
    /**
     * Retrieve customers belonging to a specific user.
     *
     * Supports customer filtering and pagination.
     *
     * @group User Customer Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     */
    public function index(User $user, CustomerFilter $filters)
    {
        return CustomerResource::collection(
            $user->customers()
                ->filter($filters)
                ->paginate()
        );
    }

    /**
     * Create a customer under a specific user.
     *
     * Regular users can only create customers under their own account.
     *
     * @group User Customer Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user who will own the customer. Example: 1
     */
    public function store(StoreCustomerRequest $request, User $user)
    {
        $authenticatedUser = $request->user();

        // Regular users can only create customers under their own account.
        if (
            $authenticatedUser->tokenCan(Abilities::CreateOwnCustomer)
            && $authenticatedUser->id !== $user->id
        ) {
            return $this->notAuthorized(
                'You are not authorized to create customers for another user.'
            );
        }

        // Check whether the authenticated user has create permission.
        if (!$this->isAble('create', Customer::class)) {
            return $this->notAuthorized(
                'You are not authorized to create this customer.'
            );
        }

        // Create customer under the specified user.
        $customer = $user->customers()->create(
            $request->mappedAttributes([
                'data.relationships.user.data.id' => 'user_id',
            ])
        );

        return new CustomerResource($customer);
    }

    /**
     * Replace a customer's information under a specific user.
     *
     * Replaces the submitted customer information.
     *
     * @group User Customer Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     * @urlParam customer integer required The ID of the customer. Example: 1
     */
    public function replace(
        ReplaceCustomerRequest $request,
        User $user,
        Customer $customer
    ) {
        if (!$this->isAble('update', $customer)) {
            return $this->notAuthorized(
                'You are not authorized to replace this customer.'
            );
        }

        $customer->update($request->mappedAttributes());

        return new CustomerResource($customer);
    }

    /**
     * Partially update a customer's information under a specific user.
     *
     * Updates only the submitted customer fields.
     *
     * @group User Customer Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     * @urlParam customer integer required The ID of the customer. Example: 1
     */
    public function update(
        UpdateCustomerRequest $request,
        User $user,
        Customer $customer
    ) {
        if (!$this->isAble('update', $customer)) {
            return $this->notAuthorized(
                'You are not authorized to update this customer.'
            );
        }

        $customer->update($request->mappedAttributes());

        return new CustomerResource($customer);
    }

    /**
     * Delete a customer's record under a specific user.
     *
     * Permanently removes the specified customer.
     *
     * @group User Customer Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     * @urlParam customer integer required The ID of the customer. Example: 1
     */
    public function destroy(User $user, Customer $customer)
    {
        if (!$this->isAble('delete', $customer)) {
            return $this->notAuthorized(
                'You are not authorized to delete this customer.'
            );
        }

        $customer->delete();

        return $this->ok('Customer successfully deleted');
    }
}
