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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::find($id);

            if ($user) {
                return response()->json(compact('user'), 200);
            }
        }

        return response()->json('User not found!', 404);
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

        if ($user) {
            return response()->json(compact('user'), 200);
        }
        
        return response()->json('User not created!', 404);
    }

    /**
     * Update a specific user
     *
     * @param UsersUpdateRequest $request
     * @param int                $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UsersUpdateRequest $request, $id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::find($id);

            if ($user) {
                $user->update($request->only('first_name', 'last_name', 'email'));

                return response()->json(compact('user'), 200);
            }
        }

        return response()->json('User not found, unable to be updated!', 404);
    }

    /**
     * Delete a specific user
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::find($id);

            if ($user) {
                $user->delete();
            
                return response()->json('User deleted!', 200);
            }
        }
        
        return response()->json('User not found, unable to be deleted!', 404);
    }
}
