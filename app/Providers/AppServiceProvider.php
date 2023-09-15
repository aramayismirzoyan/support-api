<?php

namespace App\Providers;

use App\Contracts\Request\MailServiceInterface;
use App\Http\Resources\RequestResource;
use App\Services\Request\MailNullObjectService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MailServiceInterface::class, MailNullObjectService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RequestResource::withoutWrapping();
    }
}
