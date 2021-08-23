<?php

namespace TimSDK\Group;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
	public function register(Container $pimple)
	{
		!isset($pimple['group']) && $pimple['group'] = function ($app) {
			return new Client($app);
		};
	}
}