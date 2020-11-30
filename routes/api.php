<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\UsersController;
use \App\Http\Controllers\API\SkillsController;
use \App\Http\Controllers\API\UsersSkillsController;
use \App\Http\Controllers\API\UsersVacationsController;
use \App\Http\Controllers\API\DepartmentsController;
use \App\Http\Controllers\API\DepartmentsUsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::put('/departments/addUsers', [DepartmentsUsersController::class, 'addUsersToDepartment']);
Route::put('/departments/removeUsers', [DepartmentsUsersController::class, 'removeUsersFromDepartment']);
Route::put('/departments/{id}/removeAllUsers', [DepartmentsUsersController::class, 'removeAllUsersFromDepartment']);
Route::put('/departments/managers/{user_id}', [DepartmentsController::class, 'addManager']);
Route::apiResource('users', UsersController::class);
Route::apiResource('skills', SkillsController::class);
Route::apiResource('/users/{id}/skills', UsersSkillsController::class, ['only' => ['index', 'store']]);
Route::apiResource('/users/{id}/vacations', UsersVacationsController::class);
Route::apiResource('/departments', DepartmentsController::class);
