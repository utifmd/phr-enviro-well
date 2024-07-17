<?php

namespace App\Providers;

use App\Mapper\IPostMapper;
use App\Mapper\IUserMapper;
use App\Mapper\PostMapper;
use App\Mapper\UserMapper;
use Illuminate\Support\ServiceProvider;

class PhrMapperProvider extends ServiceProvider
{
    public array $singletons = [
        IUserMapper::class => UserMapper::class,
        IPostMapper::class => PostMapper::class
    ];
    public function provides(): array
    {
        return [
            IUserMapper::class,
            IPostMapper::class
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
