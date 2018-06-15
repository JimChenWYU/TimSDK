<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 9:22 AM
 */

namespace TimSDK\Foundation\ServiceProviders;

use Pimple\Container;
use Monolog\Logger as Monolog;
use Monolog\Handler\NullHandler;
use Monolog\Handler\ErrorLogHandler;

class LogServiceProvider extends ServiceProvider
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
        $pimple['logger'] = $pimple['log'] = function () {
            $log = new Monolog('TimSDK');

            if (defined('PHPUNIT_RUNNING') || 'cli' === php_sapi_name()) {
                $log->pushHandler(new NullHandler());
            } else {
                $log->pushHandler(new ErrorLogHandler());
            }

            return $log;
        };
    }
}
