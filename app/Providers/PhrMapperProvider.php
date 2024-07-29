<?php

namespace App\Providers;

use App\Mapper\IPostMapper;
use App\Mapper\IUserMapper;
use App\Mapper\PostMapper;
use App\Mapper\UserMapper;
use App\Utils\IUtility;
use App\Utils\Utility;
use Illuminate\Support\ServiceProvider;

class PhrMapperProvider extends ServiceProvider
{
    public array $singletons = [
        IUtility::class => Utility::class,
        IUserMapper::class => UserMapper::class,
        IPostMapper::class => PostMapper::class
    ];
    public function provides(): array
    {
        return [
            IUtility::class,
            IUserMapper::class,
            IPostMapper::class,
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
