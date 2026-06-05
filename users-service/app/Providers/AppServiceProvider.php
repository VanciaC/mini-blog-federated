<?php

namespace App\Providers;

use App\GraphQL\CustomResolverProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Support\Contracts\ProvidesResolver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProvidesResolver::class,
            CustomResolverProvider::class,
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
