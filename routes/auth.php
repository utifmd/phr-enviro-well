<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Posts\Create;
use App\Livewire\Posts\Edit;
use App\Livewire\Posts\Index;
use App\Livewire\Posts\Show;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('/', 'pages.auth.register')
        ->name('register');

    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
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

    Route::get('/posts/update/{post}', Edit::class)
        ->name('posts.edit');
});
