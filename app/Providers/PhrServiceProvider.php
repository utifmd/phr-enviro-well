<?php

namespace App\Providers;

use App\Services\IPostService;
use App\Services\IUserService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class PhrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public array $singletons = [
        IUserService::class => UserService::class,
        IPostService::class => PostService::class,
    ];

    public function provides(): array
    {
        return [
            IUserService::class,
            IPostService::class
        ];
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
