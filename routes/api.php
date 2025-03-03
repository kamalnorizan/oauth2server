<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiUserController;

Route::get('/user', function (Request $request) {
    if($request->user()->tokenCan('profile-user')){
        return $request->user();
    }

    return response([
        'message' => 'Unauthorized'
    ], 401);

})->middleware(['auth:api']);

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api', 'scope:access-wallet'])->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
});

Route::get('syncusers', [ApiUserController::class, 'sync']);
