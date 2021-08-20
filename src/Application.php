<?php

namespace TimSDK;

use TimSDK\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @property \TimSDK\Account\Client $account
 * @property \TimSDK\Openim\Client  $openim
 */
class Application extends ServiceContainer
{
	protected $providers = [
		Account\ServiceProvider::class,
		Openim\ServiceProvider::class,
	];
}
