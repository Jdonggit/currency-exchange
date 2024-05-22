<?php

namespace App\Providers;

use App\Services\CurrencyExchange\ConcreteExchangeRateData;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */
    public function register(): void
    {
        $this->app->bind(CurrencyExchangeService::class, function ($app) {
            return new CurrencyExchangeService($app->make(ConcreteExchangeRateData::class));
        });
    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void
    {
        //
    }
}
