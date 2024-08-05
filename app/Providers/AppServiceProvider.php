<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class);

        Gate::define('create-post', [PostPolicy::class, 'isUserRoleIsPT']);
        Gate::define('update-post', [PostPolicy::class, 'isPhrOrUserOwnThePost']);
        Gate::define('approval-post', [PostPolicy::class, 'isUserRoleIsPhr']);
        Gate::define('delete-post', [PostPolicy::class, 'isUserOwnThePost']);
    }
}
