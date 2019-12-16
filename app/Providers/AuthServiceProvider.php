<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->role == 'superadmin';
        });

        Gate::define('isEmployee', function ($user) {
            return $user->role == 'employee';
        });

        Gate::define('isLeaveAdmin', function ($user) {
            if($user->id === 17) {
                return true;
            } 
     
            return $user->role == 'superadmin';
        });
    }
}
