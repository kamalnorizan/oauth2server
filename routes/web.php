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



Route::middleware(['auth'])->group(function () {
    require(__DIR__ . '/user.php');
    require(__DIR__ . '/subsystem.php');
});
