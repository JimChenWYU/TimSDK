<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/23/2018
 * Time: 7:37 PM
 */

namespace TimSDK\Core\ServiceProviders;

use Pimple\Container;
use TimSDK\Core\ApiAlias;
use TimSDK\Foundation\ServiceProviders\ServiceProvider;

class ApiAliasServiceProvider extends ServiceProvider
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
        $pimple['apiAlias'] = function ($pimple) {
            return new ApiAlias();
        };
    }
}
