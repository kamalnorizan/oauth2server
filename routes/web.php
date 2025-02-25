<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
