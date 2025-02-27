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
            'profile-user' => 'View profile',
            'access-eKehadiran' => 'Access eKehadiran',
            'access-ePermit' => 'Access ePermit',
            'access-eClaim' => 'Access eClaim',
            'access-eLeave' => 'Access eLeave',
            'access-wallet' => 'Access wallet',
            'transfer-funds' => 'Transfer funds',
            'view-transactions' => 'View transactions',
            'view-accounts' => 'View accounts',
        ]);


    }
}
