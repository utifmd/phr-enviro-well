<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Gate::define(UserPolicy::IS_GUEST_ROLE, [UserPolicy::class, 'isUserRoleIsGuest']);
        Gate::define(UserPolicy::IS_PT_ROLE, [UserPolicy::class, 'isUserRoleIsPT']);
        Gate::define(UserPolicy::IS_PHR_ROLE, [UserPolicy::class, 'isUserRoleIsPhr']);
        Gate::define(UserPolicy::IS_DEV_ROLE, [UserPolicy::class, 'isUserRoleIsDev']);

        Gate::define(PostPolicy::IS_USER_OR_PHR_OWNED, [PostPolicy::class, 'isPhrOrUserOwnThePost']);
        Gate::define(PostPolicy::IS_USER_OWNED, [PostPolicy::class, 'isUserOwnThePost']);

    }
}
