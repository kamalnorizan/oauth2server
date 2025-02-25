<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ApiAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:api','scope:profile-user']);

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware(['auth:api', 'scope:access-wallet'])->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
});
