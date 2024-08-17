<?php

use App\Exports\DashboardExport;
use App\Http\Controllers\DashboardExportController;
use App\Livewire\Dashboard;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', Dashboard::class)
    ->middleware(['auth'])
    ->name('index');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
