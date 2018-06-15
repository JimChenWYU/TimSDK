<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 12:05 AM
 */

namespace TimSDK\Foundation\ServiceProviders;

use Pimple\Container;
use TimSDK\Foundation\Config;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = $pimple[Config::class] = $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}
