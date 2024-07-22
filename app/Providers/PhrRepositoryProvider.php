<?php

namespace App\Providers;

use App\Repository\IPostRepository;
use App\Repository\IUploadedUrlRepository;
use App\Repository\IUserRepository;
use App\Repository\IWorkOrderRepository;
use App\Repository\PostRepository;
use App\Repository\UploadedUrlRepository;
use App\Repository\UserRepository;
use App\Repository\WorkOrderRepository;
use Illuminate\Support\ServiceProvider;

class PhrRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public array $singletons = [
        IUserRepository::class => UserRepository::class,
        IPostRepository::class => PostRepository::class,
        IUploadedUrlRepository::class => UploadedUrlRepository::class,
        IWorkOrderRepository::class => WorkOrderRepository::class
    ];

    public function provides(): array
    {
        return [
            IUserRepository::class,
            IPostRepository::class,
            IUploadedUrlRepository::class,
            IWorkOrderRepository::class
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
