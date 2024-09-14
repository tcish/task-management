<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
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
});

// Admin-specific routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // ! default routes by breeze
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('tasks', TaskController::class);
});

// Employee-specific routes
Route::middleware(['auth', 'verified', 'role:employee'])->group(function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
});

require __DIR__.'/auth.php';
