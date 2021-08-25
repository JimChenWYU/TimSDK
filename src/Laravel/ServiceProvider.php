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
            return tap(new TimSDK(config('tim-sdk')), function (TimSDK $tim) {
                // 默认使用 Laravel 缓存系统 （已实现 PSR16 规范）
                $tim->rebind('cache', $this->app['cache.store']);
                // 默认使用 Laravel Request (使用symfony/http-foundation)
                $tim->rebind('request', $this->app['request']);
            });
        });

        $this->app->alias(TimSDK::class, 'tim-sdk');
    }
}
