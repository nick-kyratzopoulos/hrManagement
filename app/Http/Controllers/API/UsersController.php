<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UsersStoreRequest;
use App\Http\Requests\User\UsersUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Get a list of users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $users = UserResource::collection(User::all());
        $count = count($users);

        return response()->json(compact('users', 'count'), 200);
    }

    /**
     * Get a single user
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user) {
        $user = new UserResource($user);

        return response()->json(compact('user'));
    }

    /**
     * Create a new user
     *
     * @param UsersStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UsersStoreRequest $request) {
        $user = User::create($request->only('first_name', 'last_name', 'email', 'password'));

        return response()->json(compact('user'), 201);
    }

    /**
     * Update a specific user
     *
     * @param UsersUpdateRequest $request
     * @param User    $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UsersUpdateRequest $request, User $user) {
        $user->update($request->only('first_name', 'last_name', 'email'));

        return response()->json(null, 204);
    }

    /**
     * Delete a specific user
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user) {
        $user->delete();

        return response()->json(null, 204);
    }
}
