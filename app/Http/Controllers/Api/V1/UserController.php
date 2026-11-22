<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class UserController extends APIController
{
    /**
     * Retrieve a paginated list of users.
     *
     * Returns the available users in the system.
     *
     * @group User Management
     *
     * @authenticated
     */
    public function index()
    {
        if (!$this->isAble('viewAny', User::class)) {
            return $this->notAuthorized(
                'You are not authorized to view users.'
            );
        }

        return UserResource::collection(
            User::paginate()
        );
    }

    /**
     * Retrieve a specific user.
     *
     * Returns the details of the selected user.
     *
     * @group User Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     */
    public function show(User $user)
    {
        if (!$this->isAble('view', $user)) {
            return $this->notAuthorized(
                'You are not authorized to view this user.'
            );
        }

        return new UserResource($user);
    }

    /**
     * Create a new user.
     *
     * Stores a new user account in the system.
     *
     * @group User Management
     *
     * @authenticated
     */
    public function store(StoreUserRequest $request)
    {
        if (!$this->isAble('create', User::class)) {
            return $this->notAuthorized(
                'You are not authorized to create users.'
            );
        }

        $user = User::create(
            $request->validated()
        );

        return new UserResource($user);
    }

    /**
     * Replace an existing user's information.
     *
     * Replaces the specified user's submitted information.
     *
     * @group User Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     */
    public function replace(
        ReplaceUserRequest $request,
        User $user
    ) {
        if (!$this->isAble('update', $user)) {
            return $this->notAuthorized(
                'You are not authorized to replace this user.'
            );
        }

        $user->update(
            $request->validated()
        );

        return new UserResource($user);
    }

    /**
     * Partially update an existing user's information.
     *
     * Updates only the submitted user fields.
     *
     * @group User Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        if (!$this->isAble('update', $user)) {
            return $this->notAuthorized(
                'You are not authorized to update this user.'
            );
        }

        $user->update(
            $request->validated()
        );

        return new UserResource($user);
    }

    /**
     * Delete a user.
     *
     * Permanently removes the specified user account.
     *
     * @group User Management
     *
     * @authenticated
     *
     * @urlParam user integer required The ID of the user. Example: 1
     */
    public function destroy(User $user)
    {
        if (!$this->isAble('delete', $user)) {
            return $this->notAuthorized(
                'You are not authorized to delete this user.'
            );
        }

        $user->delete();

        return $this->ok(
            'User successfully deleted'
        );
    }
}
