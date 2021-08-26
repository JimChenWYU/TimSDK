<?php

namespace TimSDK\Laravel;

use TimSDK\Application as TimSDK;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/tim-sdk.php' => config_path('tim-sdk.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/tim-sdk.php', 'tim-sdk');

        $this->app->singleton(TimSDK::class, function () {
            /** @var array $config */
            $config = array_merge(
                config('tim-sdk.defaults', []),
                config('tim-sdk.options.connections.'.config('tim-sdk.options.default'), [])
            );
            return tap(new TimSDK($config), function (TimSDK $tim) {
                if (config('tim-sdk.defaults.use_laravel_cache')) {
                    $tim->rebind('cache', $this->app['cache.store']);
                }
                // 默认使用 Laravel Request (使用symfony/http-foundation)
                $tim->rebind('request', $this->app['request']);
            });
        });

        $this->app->alias(TimSDK::class, 'tim-sdk');
    }
}
