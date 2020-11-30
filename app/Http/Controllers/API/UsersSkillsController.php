<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UsersSkillsStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersSkillsController extends Controller
{
    /**
     * Get a list of user's skills
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::with('skills')->find($id);

            if ($user) {
                return response()->json(['user' => $user, 'skills' => $user->skills], 200);
            }
        }

        return response()->json('User not found!', 404);
    }

    /**
     * Create a new user - skills correlation
     *
     * @param UsersSkillsStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UsersSkillsStoreRequest $request, $id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $user = User::find($id);

            if ($user) {
                $user->skills()->sync($request->skills, false);
                
                return response()->json(['user' => $user, 'skills' => $request->skills], 200);
            }
        }
        
        return response()->json('User not found!', 404);
    }
}
