<?php

namespace App\Providers;

use App\Service\IWellService;
use App\Service\WellService;
use Illuminate\Support\ServiceProvider;

class PhrServiceProvider extends ServiceProvider
{
    public array $singletons = [
        IWellService::class => WellService::class
    ];

    public function provides(): array
    {
        return [
            IWellService::class
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
