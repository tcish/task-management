<?php

use App\Http\Controllers\AssignController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Common routes
Route::middleware(['auth', 'verified'])->group(function () {
    // ! default routes by breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ? task routes
    Route::post('/tasks/update/{task}', [TaskController::class, 'update']);
    Route::resource('tasks', TaskController::class);
    
    // ? assign routes
    Route::post('/assigns-store', [AssignController::class, 'store'])->name("assigns.store");
    Route::get('/assignee-check/{taskId}/{userId}', [AssignController::class, 'checkAssignee'])->name("assigns.check");

    // ? permission routes
    Route::post('/permissions-store', [PermissionController::class, 'store'])->name("permissions.store");
    Route::get('/get-permissions-by-userId/{userId}', [PermissionController::class, 'getPermissionByUserId'])->name("permissions.userId");
    // Route::get('/permissions-check/{userId}', [PermissionController::class, 'checkPermission'])->name("permissions.check");
});

// Admin-specific routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {});

// Employee-specific routes
Route::middleware(['auth', 'verified', 'role:employee'])->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
});

require __DIR__.'/auth.php';
