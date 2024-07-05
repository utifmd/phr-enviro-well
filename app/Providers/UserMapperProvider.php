<?php

namespace App\Providers;

use App\Mapper\IUserMapper;
use App\Mapper\UserMapper;
use Illuminate\Support\ServiceProvider;

class UserMapperProvider extends ServiceProvider
{
    public array $singletons = [
        IUserMapper::class => UserMapper::class
    ];
    public function provides(): array
    {
        return [IUserMapper::class];
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
