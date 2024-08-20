<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardExportController;
use App\Livewire\Posts\Create;
use App\Livewire\Posts\Edit;
use App\Livewire\Posts\Index;
use App\Livewire\Posts\LoadRequest;
use App\Livewire\Posts\Show;
use App\Livewire\Users\Login;
use App\Livewire\Users\Register;
use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {

    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/users', \App\Livewire\Users\Index::class)
        ->name('users.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/users/create', \App\Livewire\Users\Create::class)
        ->name('users.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/users/show/{user}', \App\Livewire\Users\Show::class)
        ->name('users.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/users/update/{user}', \App\Livewire\Users\Edit::class)
        ->name('users.edit')
        ->can(UserPolicy::IS_DEV_ROLE);

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::get('/posts', Index::class)
        ->name('posts.index');

    Route::get('/load-request/{idsWellName?}', LoadRequest::class)
        ->name('posts.load-request')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/posts/create', Create::class)
        ->name('posts.create')
        ->can(UserPolicy::IS_PT_ROLE);

    Route::get('/posts/show/{post}', Show::class)
        ->name('posts.show')
        ->middleware('can:'.PostPolicy::IS_USER_OR_PHR_OWNED.',post');

    Route::get('/posts/update/{post}',Edit::class)
        ->name('posts.edit')
        ->middleware('can:'.PostPolicy::IS_USER_OR_PHR_OWNED.',post');

    Route::get('/well-masters', \App\Livewire\WellMasters\Index::class)
        ->name('well-masters.index')
        ->can(UserPolicy::IS_NOT_GUEST_ROLE);

    Route::get('/well-masters/create', \App\Livewire\WellMasters\Create::class)
        ->name('well-masters.create')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/well-masters/show/{wellMaster}', \App\Livewire\WellMasters\Show::class)
        ->name('well-masters.show')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/well-masters/update/{wellMaster}', \App\Livewire\WellMasters\Edit::class)
        ->name('well-masters.edit')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/export-to-excel/{datetime}', [DashboardExportController::class, 'export'])
        ->name('dashboard.export')
        ->can(UserPolicy::IS_PHR_ROLE);

    /*Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');*/

});
