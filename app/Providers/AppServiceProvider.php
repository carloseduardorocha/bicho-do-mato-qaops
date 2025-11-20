<?php

namespace App\Providers;

use App\Services\NewsService;
use App\Services\PartnerService;
use App\Services\TestimonialService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NewsService::class);
        $this->app->singleton(PartnerService::class);
        $this->app->singleton(TestimonialService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar paginação para usar Bootstrap 5
        Paginator::useBootstrapFive();
    }
}
