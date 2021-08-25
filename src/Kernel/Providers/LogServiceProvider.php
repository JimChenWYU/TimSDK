<?php

namespace TimSDK\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TimSDK\Kernel\Log\LogManager;

class LogServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['log'] ?? $pimple['log'] = function ($app) {
            $config = $this->formatLogConfig($app);

            if (!empty($config)) {
                $app->rebind('config', $app['config']->merge($config));
            }

            return new LogManager($app);
        };

        !isset($pimple['logger']) && $pimple['logger'] = $pimple['log'];
    }

    public function formatLogConfig($app)
    {
        if (!empty($app['config']->get('log.channels'))) {
            return $app['config']->get('log');
        }

        if (empty($app['config']->get('log'))) {
            return [
                'log' => [
                    'default' => 'null',
                    'channels' => [
                        'null' => [
                            'driver' => 'null',
                        ],
                    ],
                ],
            ];
        }

        return [
            'log' => [
                'default' => 'single',
                'channels' => [
                    'single' => [
                        'driver' => 'single',
                        'path' => $app['config']->get('log.file') ?: sys_get_temp_dir() . '/logs/volcengine.log',
                        'level' => $app['config']->get('log.level', 'debug'),
                    ],
                ],
            ],
        ];
    }
}
