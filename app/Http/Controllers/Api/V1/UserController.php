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
     * Display a listing of users.
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
     * Display the specified user.
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
     * Store a newly created user.
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
     * Replace the specified user.
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
     * Update the specified user.
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
     * Remove the specified user.
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
