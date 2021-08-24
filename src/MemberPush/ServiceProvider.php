<?php

namespace TimSDK\MemberPush;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
	    $pimple['member_push'] ?? $pimple['member_push'] = function ($app) {
            return new Client($app);
        };
    }
}
