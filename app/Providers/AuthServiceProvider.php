<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; 

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    Gate::before(function ($user, $ability) {
        if ($user instanceof \App\Models\Admin && $user->hasRole('superadmin')) {
                return true;
            }
        if (Auth::guard('admin')->check() && $user->hasPermissionTo($ability, 'admin')) {
            return true;
        }
    });
    }
}
