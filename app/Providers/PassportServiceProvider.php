<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\CustomAccessTokenController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\CustomApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use App\Http\Controllers\Passport\CustomAuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;

class PassportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthorizationController::class, CustomAuthorizationController::class);
    }

    public function boot()
    {
        //
    }
}
