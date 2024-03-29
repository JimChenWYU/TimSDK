<?php

namespace TimSDK\Sns;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['sns'] ?? $pimple['sns'] = function ($app) {
            return new Client($app);
        };
    }
}
