<?php

namespace TimSDK\Auth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
	public function register(Container $pimple)
	{
		$pimple['user_sig'] ?? $pimple['user_sig'] = function ($app) {
			return new UserSig($app);
		};
	}
}
