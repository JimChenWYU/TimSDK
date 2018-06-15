<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 12:14 AM
 */

namespace TimSDK\Foundation\ServiceProviders;

use GuzzleHttp\Client;
use Pimple\Container;

class HttpClientServiceProvider extends ServiceProvider
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
        $pimple['httpClient'] = $pimple[Client::class] = function ($app) {
            return new Client(array_merge($app['config']->get('http', []), [
                'verify' => realpath($app->basePath('Cert/cacert.pem'))
            ]));
        };
    }
}
