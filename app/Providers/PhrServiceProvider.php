<?php

namespace App\Providers;

use App\Service\IPostService;
use App\Service\PostService;
use Illuminate\Support\ServiceProvider;

class PhrServiceProvider extends ServiceProvider
{
    public array $singletons = [
        IPostService::class => PostService::class
    ];

    public function provides(): array
    {
        return [
            IPostService::class
        ];
    }

    /**
     * Register services.
     */
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
