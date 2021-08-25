<?php

namespace TimSDK\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TimSDK\Kernel\Config;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['config'] ?? $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}
