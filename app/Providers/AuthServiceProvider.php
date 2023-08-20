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
    public const ACCESS_USER_MANAGEMENT = 'access-user-management';
    public const ACCESS_PROFILE = 'access-profile';

    public static $accessFeatures = [
        self::ACCESS_DASHBOARD => ['admin'],
        self::ACCESS_USER_MANAGEMENT => ['admin'],
        self::ACCESS_PROFILE => ['member','admin'],
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // use Illuminate\Support\Facades\Gate;
        foreach (self::$accessFeatures as $accessKey => $rolesValue) {
            Gate::define($accessKey, function(User $user) use ($rolesValue){
                return in_array($user->role, $rolesValue);
            });
        }
    }
}
