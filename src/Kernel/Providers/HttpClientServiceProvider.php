<?php

namespace TimSDK\Kernel\Providers;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TimSDK\Kernel\Http\Client;
use TimSDK\Kernel\Http\GuzzleMiddleware;

class HttpClientServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['http_client'] ?? $pimple['http_client'] = function ($app) {
            return new Client(array_merge($app['config']->get('http', []), [
	            'handler' => $this->getHandlerStack($app)
            ]));
        };
    }

    /**
     * Build a handler stack.
     */
    protected function getHandlerStack($app): HandlerStack
    {
        if (isset($app['guzzle_handler'])) {
            $handler = $app->raw('guzzle_handler');
            $handler = is_string($app['guzzle_handler']) ? new $handler() : $handler;
        } else {
            $handler = Utils::chooseHandler();
        }
        $handlerStack = HandlerStack::create($handler);
	    $handlerStack->push(GuzzleMiddleware::retry($app['config']->get('http.max_retries', 1), $app['config']->get('http.retry_delay', 500)), 'retry');
	    $handlerStack->push(GuzzleMiddleware::log($app['logger'], $app['config']['http.log_template']), 'log');

        return $handlerStack;
    }
}
