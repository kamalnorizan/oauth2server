<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubSystemController;

Route::group([
    'prefix' => 'sub-systems',
    'namespace' => 'subsystem',
    'middleware' => ['auth'],

], function () {
    Route::get('/', [SubSystemController::class, 'index'])->name('sub-systems.index');
    Route::post('/', [SubSystemController::class, 'store'])->name('sub-systems.store');
    Route::get('/sso/login/{uuid}', [SubSystemController::class, 'ssologin'])->name('sub-systems.ssologin');
    Route::get('/getPassportClient/{id}', [SubSystemController::class, 'getPassportClient'])->name('sub-systems.getPassportClient');
    Route::put('/{id}', [SubSystemController::class, 'update'])->name('sub-systems.update');
});
