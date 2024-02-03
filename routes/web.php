<?php

use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => true]);
// Auth::routes();
Route::middleware('auth')->group(function()
{
    Route::get('/',[PageController::class,'home'])->name('home');

    Route::resource('employee',EmployeeController::class);
    Route::get('employee/datatable/ssd',[EmployeeController::class,'ssd']);

    Route::get('profile',[ProfileController::class,'profile'])->name('profile.profile');

    Route::resource('department',DepartmentController::class);
    Route::get('department/datatable/ssd',[DepartmentController::class,'ssd']);

    Route::resource('role',RoleController::class);
    Route::get('role/datatable/ssd',[RoleController::class,'ssd']);

    Route::resource('permission',PermissionController::class);
    Route::get('permission/datatable/ssd',[PermissionController::class,'ssd']);

    Route::resource('company-setting',CompanySettingController::class)->only(['edit','delete','show']);
}
);
