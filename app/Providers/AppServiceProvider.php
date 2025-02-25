<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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
        Passport::loadKeysFrom(storage_path('oauth'));

        Passport::tokensCan([
            'access-wallet' => 'Access wallet',
            'transfer-funds' => 'Transfer funds',
        ]);

        Passport::setDefaultScope([
            'profile-user',
        ]);
    }
}
