<?php

namespace TimSDK;

use TimSDK\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @property \TimSDK\Account\Client $account
 */
class Application extends ServiceContainer
{
	protected $providers = [
		Account\ServiceProvider::class,
	];
}
