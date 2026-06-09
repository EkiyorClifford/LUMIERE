<?php

namespace App\Providers;

use App\Http\ViewComposers\CartComposer;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, fn ($app) => new CartService);
        $this->app->singleton(WishlistService::class, fn ($app) => new WishlistService);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', CartComposer::class);
    }
}
