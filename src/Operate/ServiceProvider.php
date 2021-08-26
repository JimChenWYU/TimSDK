<?php

namespace TimSDK\Operate;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['operate'] ?? $pimple['operate'] = function ($app) {
            return new Client($app);
        };
    }
}
