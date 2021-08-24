<?php

namespace TimSDK\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TimSDK\Kernel\Usersig;

class UsersigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['usersig'] ?? $pimple['usersig'] = function ($app) {
            return new Usersig($app);
        };
    }
}
