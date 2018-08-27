<?php

namespace App\Providers;

use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //To fix migration error: max key length is 1000 bytes
        Schema::defaultStringLength(191);
        URL::forceScheme('https');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(PostRepositoryInterface::class, PostRepository::class);
    }
}
