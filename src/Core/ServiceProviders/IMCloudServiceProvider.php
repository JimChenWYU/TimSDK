<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 8:58 PM
 */

namespace TimSDK\Core\ServiceProviders;

use Pimple\Container;
use TimSDK\Service\IMCloud;
use TimSDK\Service\TLSSigApi;
use TimSDK\Foundation\ServiceProviders\ServiceProvider;

class IMCloudServiceProvider extends ServiceProvider
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
        $pimple[IMCloud::class] = $pimple['im'] = function ($app) {
            return new IMCloud($app);
        };

        $pimple[TLSSigApi::class] = $pimple['TLSSig'] = function ($app) {
            $api = new TLSSigApi();
            $api->setAppid($app['config']->get('sdkappid'));
            $api->setPrivateKey($app['config']->get('prikey'));
            $api->setPublicKey($app['config']->get('pubkey'));

            return $api;
        };
    }
}
