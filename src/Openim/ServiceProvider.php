<?php

namespace TimSDK\Openim;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
	public function register(Container $pimple)
	{
		!isset($pimple['openim']) && $pimple['openim'] = function ($app) {
			return new Client($app);
		};
	}
}