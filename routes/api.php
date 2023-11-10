<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DepartmentsController;
use App\Http\Controllers\admin\EmployeesController;
use App\Http\Controllers\admin\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



//login
Route::post('admin-login',[AuthController::class,'login']);


Route::group(['prefix'=>'admin','middleware'=>['auth:api']],function(){

    //logout
Route::get('admin-logout',[AuthController::class,'logout']);

//employees
Route::resource('employee',EmployeesController::class);
Route::get('employee-search',[EmployeesController::class,'search']);

//departments
Route::resource('departments',DepartmentsController::class);
Route::get('departments-search',[DepartmentsController::class,'search']);

//tasks
Route::resource('tasks',TasksController::class);
Route::post('assign-task',[TasksController::class,'assignTask']);

Route::get('employee-tasks/{employee_id}',[TasksController::class,'employeeTasks']);


});
