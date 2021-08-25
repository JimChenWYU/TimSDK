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
			return new TimSDK(config('tim-sdk'));
		});

		$this->app->alias(TimSDK::class, 'tim-sdk');
	}
}