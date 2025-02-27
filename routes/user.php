<?php
use App\Http\Controllers\UserController;

Route::group([
    'prefix'     => 'users',
    'namespace'  => 'user',
    'middleware' => ['auth'],

], function() {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
});
