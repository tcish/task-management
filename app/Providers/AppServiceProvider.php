<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Task;
use App\Models\TaskPermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        Gate::define('is-admin', function () {
            return Auth::user()->role === 'admin';
        });

         // Define a gate can assign task permission
        Gate::define('can_assign', function () {
            if (Auth::user()->role == "employee") {
                $permission = TaskPermission::where("permit_to", Auth::user()->id)->select("can_assign")->first();
    
                return empty($permission) ? false : ($permission->can_assign ? true : false);
            } else if(Auth::user()->role == "admin") {
                return true;
            }
        });

        // Define a gate can create task permission
        Gate::define('can_create', function () {
            if (Auth::user()->role == "employee") {
                $permission = TaskPermission::where("permit_to", Auth::user()->id)->select("can_create")->first();

                return empty($permission) ? false : ($permission->can_create ? true : false);
            } else if(Auth::user()->role == "admin") {
                return true;
            }
        });
    }
}
