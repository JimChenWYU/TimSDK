<?php

namespace TimSDK\Account;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        !isset($pimple['account']) && $pimple['account'] = function ($app) {
            return new Client($app);
        };
    }
}
