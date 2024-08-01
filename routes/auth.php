<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Posts\Create;
use App\Livewire\Posts\Edit;
use App\Livewire\Posts\Index;
use App\Livewire\Posts\Show;
use App\Livewire\Users\Login;
use App\Livewire\Users\Register;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {

    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');


    /*Volt::route('/', 'pages.auth.register')
        ->name('register');

    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');*/

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    /*Route::get('/users', \App\Livewire\Users\Index::class)
        ->name('users.index');

    Route::get('/users/create', \App\Livewire\Users\Create::class)
        ->name('users.create');

    Route::get('/users/show/{user}', \App\Livewire\Users\Show::class)
        ->name('users.show');

    Route::get('/users/update/{user}', \App\Livewire\Users\Edit::class)
        ->name('users.edit');*/

    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::get('/posts', Index::class)
        ->name('posts.index');

    Route::get('/posts/create', Create::class)
        ->name('posts.create');

    Route::get('/posts/show/{post}', Show::class)
        ->name('posts.show');

    Route::get('/posts/update/{post}',Edit::class)
        ->name('posts.edit'); /*function (){ return redirect('/posts'); }*/

    Route::get('/well-masters', \App\Livewire\WellMasters\Index::class)
        ->name('well-masters.index');

    Route::get('/well-masters/create', \App\Livewire\WellMasters\Create::class)
        ->name('well-masters.create');

    Route::get('/well-masters/show/{wellMaster}', \App\Livewire\WellMasters\Show::class)
        ->name('well-masters.show');

    Route::get('/well-masters/update/{wellMaster}', \App\Livewire\WellMasters\Edit::class)
        ->name('well-masters.edit');
});
