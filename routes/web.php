<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubSystemController;

// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('posts', [PostController::class, 'index'])->name('posts.index');

Route::get('sub-systems', [SubSystemController::class, 'index'])->name('sub-systems.index');
Route::post('sub-systems', [SubSystemController::class, 'store'])->name('sub-systems.store');
