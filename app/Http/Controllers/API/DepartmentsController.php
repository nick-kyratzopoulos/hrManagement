<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentsStoreRequest;
use App\Http\Requests\Department\DepartmentsUpdateRequest;
use App\Http\Requests\Department\DepartmentsManagersUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Get a list of departments
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $departments = Department::all();
        $count = count($departments);

        return response()->json(compact('departments', 'count'), 200);
    }

    /**
     * Get a single department
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $id = (int)$id;

        if ($id > 0) {
            $department = Department::find($id);

            if ($department) {
                return response()->json(compact('department'), 200);
            }
        }

        return response()->json('Department not found!', 404);
    }

    /**
     * Create a new department
     *
     * @param DepartmentsStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartmentsStoreRequest $request) {
        $department = Department::create($request->only('title'));

        if ($department) {
            return response()->json(compact('department'), 200);
        }
        
        return response()->json('Department not created!', 404);
    }

    /**
     * Update a specific department
     *
     * @param DepartmentsUpdateRequest $request
     * @param int                $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepartmentsUpdateRequest $request, $id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $department = Department::find($id);

            if ($department) {
                $department->update($request->only('title'));

                return response()->json(compact('department'), 200);
            }
        }

        return response()->json('Department not found, unable to be updated!', 404);
    }

    /**
     * Delete a specific department
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $department = Department::find($id);

            if ($department) {
                $department->delete();
            
                return response()->json('Department deleted!', 200);
            }
        }
        
        return response()->json('Department not found, unable to be deleted!', 404);
    }

    /**
     * Add a manager to department
     *
     * @param DepartmentsManagersUpdateRequest $request
     * @param int $user_id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addManager(DepartmentsManagersUpdateRequest $request, $user_id) {
        $user_id = (int)$user_id;
        
        if ($user_id > 0) {
            $user       = User::find($user_id);
            $department = Department::find((int)$request->department_id);

            if ($user && $department) {
                $user->update(['manager_at_department_id' => (int)$department->id, 'department_id' => (int)$department->id]);

                return response()->json(compact('user'), 200);
            }
        }
        
        return response()->json('Department-User not found!', 404);
    }
}
