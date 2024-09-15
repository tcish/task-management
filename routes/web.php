<?php

use App\Http\Controllers\AssignController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Common routes
Route::middleware(["auth", "verified"])->group(function () {
    // ! default routes by breeze
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");

    // ? task routes
    Route::post("/tasks/update/{task}", [TaskController::class, "update"])->middleware("can:is-admin");
    Route::get("/tasks-mark-complete/{task}", [TaskController::class, "markComplete"])->name("tasks.mark.complete");
    Route::resource("tasks", TaskController::class);
    
    // ? assign routes
    Route::post("/assigns-store", [AssignController::class, "store"])->name("assigns.store")->middleware("can:can_assign");
    Route::get("/assignee-check/{taskId}/{userId}", [AssignController::class, "checkAssignee"])->name("assigns.check")->middleware("can:can_assign");

    // ? permission routes
    Route::post("/permissions-store", [PermissionController::class, "store"])->name("permissions.store")->middleware("can:is-admin");
    Route::get("/get-permissions-by-userId/{userId}", [PermissionController::class, "getPermissionByUserId"])->name("permissions.userId")->middleware("can:is-admin");
});

// Admin-specific routes
Route::middleware(["auth", "verified", "role:admin"])->group(function () {});

// Employee-specific routes
Route::middleware(["auth", "verified", "role:employee"])->group(function () {});

require __DIR__."/auth.php";
