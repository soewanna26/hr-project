<?php

use Laragear\WebAuthn\WebAuthn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CheckinCheckoutController;
use App\Http\Controllers\MyAttendanceController;

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
Route::get('checkin-checkout',[CheckinCheckoutController::class, 'checkInCheckOut'])->name('checkin-checkout');
Route::post('checkin-checkout/store',[CheckinCheckoutController::class, 'checkInCheckOutStore']);

Route::get('/login-option',[LoginController::class,'loginOption'])->name('login-option');
WebAuthn::routes();

Route::middleware('auth')->group(function()
{
    Route::get('/',[PageController::class,'home'])->name('home');

    Route::resource('employee',EmployeeController::class);
    Route::get('employee/datatable/ssd',[EmployeeController::class,'ssd']);

    Route::get('profile',[ProfileController::class,'profile'])->name('profile.profile');
    Route::get('profile/biometric-data',[ProfileController::class,'biometricsData']);
    Route::delete('profile/biometric-data/{id}',[ProfileController::class,'biometricsDestroy']);

    Route::resource('department',DepartmentController::class);
    Route::get('department/datatable/ssd',[DepartmentController::class,'ssd']);

    Route::resource('role',RoleController::class);
    Route::get('role/datatable/ssd',[RoleController::class,'ssd']);

    Route::resource('permission',PermissionController::class);
    Route::get('permission/datatable/ssd',[PermissionController::class,'ssd']);

    Route::resource('company-setting',CompanySettingController::class)->only(['edit','show','update']);

    Route::resource('attendance',AttendanceController::class);
    Route::get('attendance/datatable/ssd',[AttendanceController::class,'ssd']);
    Route::get('attendance-overview',[AttendanceController::class,'overview'])->name('attendance.overview');
    Route::get('attendance-overview-table',[AttendanceController::class,'overviewTable']);

    Route::get('/attendance-scan',[AttendanceScanController::class,'scan'])->name('attendance-scan');
    Route::post('/attendance-scan/store',[AttendanceScanController::class,'scanStore'])->name('attendance-scan.store');

    Route::get('my-attendance/datatable/ssd',[MyAttendanceController::class,'ssd']);
    Route::get('my-attendance-overview-table',[MyAttendanceController::class,'overviewTable']);
}
);
