<?php

namespace App\Providers;

use App\Services\IUserService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public array $singletons = [
        IUserService::class => UserService::class
    ];

    public function provides(): array
    {
        return [IUserService::class];
    }

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
