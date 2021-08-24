<?php

namespace TimSDK\Overall;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
	    $pimple['overall'] ?? $pimple['overall'] = function ($app) {
            return new Client($app);
        };
    }
}
