<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
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
        $departments = DepartmentResource::collection(Department::all());

        return response()->json(compact('departments'), 200);
    }

    /**
     * Show a department's details
     *
     * @param Department $department
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Department $department) {
        $department = new DepartmentResource($department);

        return response()->json(compact('department'), 200);
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

        return response()->json(['department' => new DepartmentResource($department)], 201);
    }

    /**
     * Update a department
     *
     * @param Department    $department
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse]
     */
    public function update(Department $department, UpdateRequest $request) {
        $department->update($request->only('title'));

        return response()->json(null, 204);
    }

    /**
     * Delete a department
     *
     * @param Department $department
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Department $department) {
        $department->delete();

        return response()->json(null, 204);
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
                $user->update(['department_id' => (int)$department->id]);

                $department->update(['manager_id' => (int)$user->id]);

                return response()->json(compact('user'), 200);
            }
        }
        
        return response()->json('Department-User not found!', 404);
    }
}
