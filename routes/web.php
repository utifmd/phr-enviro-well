<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Dashboard::class)
    ->middleware(['auth'])
    ->name('index');

Route::get('dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
