<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VacationResource;
use App\Http\Requests\User\UsersVacationsStoreRequest;
use App\Http\Requests\User\UsersVacationsUpdateRequest;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;

class UsersVacationsController extends Controller
{
    /**
     * Get a list of user's vacations
     * 
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::with('vacations')->find($id);

            if ($user) {
                return response()->json(['user' => $user, 'vacations' => $user->vacations], 201);
            }
        }

        return response()->json('User not found!', 404);
    }

    /**
     * Get a single vacation-user
     *
     * @param int $user_id
     * @param int $vacation_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_id, $vacation_id) {
        $user_id     = (int)$user_id;
        $vacation_id = (int)$vacation_id;
        
        if ($user_id > 0 && $vacation_id > 0) {
            $user = User::with('vacations')->find($user_id);

            if ($user) {
                $vacation = new VacationResource(Vacation::find($vacation_id));
                
                if ($vacation) {
                    if ((int)$vacation->user->id === (int)$user_id) {
                        return response()->json(compact('vacation'), 200);
                    }

                    return response()->json('Vacation-User not found!', 404);
                }
            }
        }

        return response()->json('User not found!', 404);
    }

    /**
     * Create a new user - vacations correlation
     *
     * @param UsersVacationsStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UsersVacationsStoreRequest $request, $id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::find($id);

            if ($user) {
                $fromTimestamp = strtotime($request->from);
                $toTimestamp   = strtotime($request->to);

                if ($fromTimestamp > $toTimestamp) {
                    return response()->json('Wrong data on dates!');
                }

                $vacation = Vacation::create(['from' => $request->from, 'to' => $request->to, 'user_id' => $id]);
                
                return response()->json(['user' => $user, 'vacation' => $vacation], 200);
            }
        }
        
        return response()->json('User not found!', 404);
    }

    /**
     * Update a specific vacation-user
     *
     * @param UsersVacationsUpdateRequest $request
     * @param int $user_id
     * @param int $vacation_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UsersVacationsUpdateRequest $request, $user_id, $vacation_id) {
        $user_id     = (int)$user_id;
        $vacation_id = (int)$vacation_id;
        
        if ($user_id > 0 && $vacation_id > 0) {
            $user = User::find($user_id);

            if ($user) {
                $vacation = Vacation::find($vacation_id);

                if ($vacation) {
                    if ((int)$vacation->user->id === (int)$user_id) {
                        $fromTimestamp = strtotime($request->from);
                        $toTimestamp   = strtotime($request->to);
            
                        if ($fromTimestamp > $toTimestamp) {
                            return response()->json('Wrong data on dates!');
                        }

                        $vacation->update($request->only('from', 'to'));

                        return response()->json(compact('vacation'), 200);
                    }

                    return response()->json('Vacation-User not found!', 404);
                }
            }
        }

        return response()->json('User not found, unable to be updated!', 404);
    }

    /**
     * Delete a specific user
     *
     * @param int $user_id
     * @param int $vacation_id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($user_id, $vacation_id) {
        $user_id     = (int)$user_id;
        $vacation_id = (int)$vacation_id;
        
        if ($user_id > 0 && $vacation_id > 0) {
            $user = User::find($user_id);

            if ($user) {
                $vacation = Vacation::find($vacation_id);

                if ($vacation) {
                    if ((int)$vacation->user->id === (int)$user_id) {
                        $vacation->delete();

                        return response()->json('Vacation-User deleted!', 200);
                    }

                    return response()->json('Vacation-User not found!', 404);
                }
            }
        }
        
        return response()->json('User not found, unable to be deleted!', 404);
    }
}
