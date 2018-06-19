<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 9:22 AM
 */

namespace TimSDK\Foundation\ServiceProviders;

use Monolog\Handler\NullHandler;
use Pimple\Container;
use TimSDK\Foundation\Log\LogManager;
use TimSDK\Support\Arr;

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
        $pimple['logger'] = $pimple['log'] = function ($app) {
            $config = $this->formatLogConfig($app);

            if (!empty($config)) {
                $app['config']->merge($config);
            }

            $log = new LogManager($app);

            if (defined('PHPUNIT_RUNNING') || 'cli' === php_sapi_name()) {
                if (Arr::get($config, 'cli_on', false)) {
                    $log->setDefaultDriver('errorlog')
                        ->addChannels([
                            'errorlog' => [
                                'driver' => 'errorlog',
                                'level'  => 'info',
                            ],
                        ]);
                } else {
                    $log->driver()->pushHandler(new NullHandler());
                }
            }

            return $log;
        };
    }

    public function formatLogConfig($app)
    {
        if (empty($app['config']->get('log'))) {
            return [
                'log' => [
                    'cli_on'   => false,
                    'default'  => 'errorlog',
                    'channels' => [
                        'errorlog' => [
                            'driver' => 'errorlog',
                            'level'  => 'debug',
                        ],
                    ],
                ],
            ];
        }
        // 4.0 version
        if (empty($app['config']->get('log.driver'))) {
            return [
                'log' => [
                    'cli_on'   => false,
                    'default'  => 'single',
                    'channels' => [
                        'single' => [
                            'driver' => 'single',
                            'path'   => $app['config']->get('log.file') ?: \sys_get_temp_dir() . '/logs/tim-sdk.log',
                            'level'  => $app['config']->get('log.level', 'debug'),
                        ],
                    ],
                ],
            ];
        }
        $name = $app['config']->get('log.driver');

        return [
            'log' => [
                'cli_on'   => false,
                'default'  => $name,
                'channels' => [
                    $name => $app['config']->get('log'),
                ],
            ],
        ];
    }
}
