<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('role', RoleMiddleware::class);

        Schema::defaultStringLength(191);

        // Define a gate for admin check
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

         // Define a gate for viewing a task
        Gate::define('view-task', function (User $user, Task $task) {
            return $user->id === $task->user_id;
        });

        // Define a gate for creating a task
        Gate::define('create-task', function (User $user) {
            return $user->role === 'admin'; // Only admin can create tasks
        });

        // Define a gate for updating a task
        Gate::define('update-task', function (User $user, Task $task) {
            return $user->id === $task->user_id;
        });

        // Define a gate for deleting a task
        Gate::define('delete-task', function (User $user, Task $task) {
            return $user->id === $task->user_id;
        });
    }
}
