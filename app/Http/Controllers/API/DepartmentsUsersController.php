<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DepartmentsUsersAddRequest;
use App\Http\Requests\User\DepartmentsUsersRemoveRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentsUsersController extends Controller
{
    /**
     * Add users to department
     *
     * @param DepartmentsUsersAddRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addUsersToDepartment(DepartmentsUsersAddRequest $request) {
        $users      = User::findMany($request->users);
        $department = Department::find((int)$request->department_id);

        if ($users && $department) {
            foreach ($users as $user) {
                $user->update(['department_id' => (int)$department->id]);
            }

            return response()->json(compact('users'), 200);
        }
        
        return response()->json('Department-users not found!', 404);
    }

    /**
     * Remove users from department
     *
     * @param DepartmentsUsersRemoveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeUsersFromDepartment(DepartmentsUsersRemoveRequest $request) {
        $users      = User::findMany($request->users);
        $department = Department::find((int)$request->department_id);

        if ($users && $department) {
            foreach ($users as $user) {
                $user->update(['manager_at_department_id' => null, 'department_id' => null]);
            }

            return response()->json(compact('users'), 200);
        }
        
        return response()->json('Department-users not found!', 404);
    }

    /**
     * Remove all users from department
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeAllUsersFromDepartment($id) {
        $id = (int)$id;
        
        if ($id > 0) {
            $department = Department::find((int)$id);

            if ($department) {
                $users = $department->users;

                foreach ($users as $user) {
                    $user->update(['manager_at_department_id' => null, 'department_id' => null]);
                }

                return response()->json('All users removed from department.', 200);
            }
        }
        
        return response()->json('Department not found!', 404);
    }
}
