<?php

namespace TimSDK\Account;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
	    $pimple['account'] ?? $pimple['account'] = function ($app) {
            return new Client($app);
        };
    }
}
