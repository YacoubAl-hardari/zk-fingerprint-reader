<?php

namespace Yacoubalhaidari\ZKFinger;

use Illuminate\Support\ServiceProvider;
use Yacoubalhaidari\ZKFinger\Services\ZKFingerAgentClient;

class ZKFingerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/zkfinger.php' => config_path('zkfinger.php'),
        ], 'zkfinger-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/zkfinger.php', 'zkfinger');

        $this->app->singleton(ZKFingerAgentClient::class, function ($app) {
            return new ZKFingerAgentClient();
        });
    }
}
