<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

    public const ACCESS_DASHBOARD = 'access-dashboard';

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // use Illuminate\Support\Facades\Gate;
        Gate::define(self::ACCESS_DASHBOARD, function(User $user){

          return in_array($user->role, ['admin'])
            ? AccessResponse::allow()
            : AccessResponse::deny('You must be an administrator');

        });
    }
}
