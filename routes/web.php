<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::resource('/admin', \App\Http\Controllers\AdminController::class)->names([
        'index' => 'admin.index',
        'create' => 'admin.create',
        'store' => 'admin.store',
        'show' => 'admin.show',
        'edit' => 'admin.edit',
        'update' => 'admin.update',
        'destroy' => 'admin.destroy',
    ]);

    Route::resource('/employee', \App\Http\Controllers\EmployeeController::class)->names([
        'index' => 'employee.index',
        'create' => 'employee.create',
        'store' => 'employee.store',
        'show' => 'employee.show',
        'edit' => 'employee.edit',
        'update' => 'employee.update',
        'destroy' => 'employee.destroy',
    ]);

    Route::resource('/leave-request', \App\Http\Controllers\LeaveRequestController::class)->names([
        'index' => 'leave-request.index',
        'create' => 'leave-request.create',
        'store' => 'leave-request.store',
        'show' => 'leave-request.show',
        'edit' => 'leave-request.edit',
        'update' => 'leave-request.update',
        'destroy' => 'leave-request.destroy',
    ]);

    Route::get('employee-paid-leave', [\App\Http\Controllers\EmployeePaidLeaveController::class,'index'])->name('employee-paid-leave.index');
    Route::get('employee-paid-leave/{employee}', [\App\Http\Controllers\EmployeePaidLeaveController::class,'show'])->name('employee-paid-leave.show');
});
