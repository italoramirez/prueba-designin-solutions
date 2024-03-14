<?php

namespace App\Providers;

use App\Http\Repositories\Auth\Impl\AuthRepositoryImpl;
use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Repositories\User\Impl\UserRepositoryImpl;
use App\Http\Repositories\User\UserRepository;
use App\Services\Auth\Impl\AuthServiceImpl;
use App\Services\Auth\AuthService;
use App\Services\Users\Impl\UserServiceImpl;
use App\Services\Users\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Services
        /*Auth*/
        $this->app->bind(AuthService::class, AuthServiceImpl::class);

        /*User*/
        $this->app-> bind(UserService::class, UserServiceImpl::class);

        //Repositories
        $this->app->bind(AuthRepository::class, AuthRepositoryImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
