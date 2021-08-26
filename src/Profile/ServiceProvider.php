<?php

namespace TimSDK\Profile;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['profile'] ?? $pimple['profile'] = function ($app) {
            return new Client($app);
        };
    }
}
