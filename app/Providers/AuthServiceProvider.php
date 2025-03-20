<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Auth\ApiGuard;
use App\Auth\ApiUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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

        // Register our custom provider
        Auth::provider('api', function ($app, array $config) {
            return new ApiUserProvider();
        });

        // Register our custom guard
        Auth::extend('api', function ($app, $name, array $config) {
            return new ApiGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request')
            );
        });
    }
}
