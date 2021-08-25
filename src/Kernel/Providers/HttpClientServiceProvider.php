<?php

namespace TimSDK\Kernel\Providers;

use Exception;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Utils;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;
use TimSDK\Kernel\Http\Client;

class HttpClientServiceProvider implements ServiceProviderInterface
{
	/**
	 * @var array
	 */
	protected $middlewares = [];

	/**
	 * @param Container $pimple
	 */
	public function register(Container $pimple)
    {
	    $pimple['http_client'] ?? $pimple['http_client'] = function ($app) {
		    return $this->createHttpClient($app);
        };
    }

	/**
	 * @param $app
	 * @return \TimSDK\Kernel\Http\Client
	 * @throws Exception
	 */
	protected function createHttpClient($app): ClientInterface
	{
		$this->pushMiddleware($this->logMiddleware($app), 'log');
		$this->pushMiddleware($this->retryMiddleware($app), 'retry');

		return new Client(array_merge($app['config']->get('http', []), [
			'handler' => $this->getHandlerStack($app)
		]));
	}

	/**
	 * Log the request.
	 *
	 * @return callable
	 */
	protected function logMiddleware($app)
	{
		$formatter = new MessageFormatter($this->app['config']['http.log_template'] ?? MessageFormatter::DEBUG);

		return Middleware::log($app['logger'], $formatter, LogLevel::DEBUG);
	}

	/**
	 * Return retry middleware.
	 *
	 * @return callable
	 */
	protected function retryMiddleware($app)
	{
		return Middleware::retry(function (
			$retries,
			RequestInterface $request,
			ResponseInterface $response = null
		) use ($app) {
			// Limit the number of retries to 2
			if ($retries < $app['config']->get(
					'http.max_retries',
					1
				) && $response && $body = $response->getBody()) {
				// 网络错误重试
				if ($response->getStatusCode() !== 200) {
					return true;
				}
				// 业务错误重试场景
				$response = json_decode((string)$body, true);
				if (in_array($response['ErrorCode'], [
					-10007, // 验证码下发超时。
					114005, // 资源文件（如图片、文件、语音、视频）传输超时，一般是网络问题导致。

					60008, // 服务请求超时或 HTTP 请求格式错误，请检查并重试。
					60014, // 置换帐号超时。

					70169, // 服务端内部超时，请稍后重试。
					70202, // 服务端内部超时，请稍后重试。
					70500, // 服务端内部超时，请稍后重试。

					40006, // 服务端内部超时，请稍后重试。

					30006, // 服务端内部错误，请重试。
					30007, // 网络超时，请稍后重试。
					50004, // 服务端内部错误，请重试。
					50005, // 网络超时，请稍后重试。

					20004, // 网络异常，请重试。
					20005, // 服务端内部错误，请重试。
					22002, // 网络异常，请重试。
					90994, // 服务内部错误，请重试。
					90995, // 服务内部错误，请重试。
					91000, // 服务内部错误，请重试。

					10002, // 服务端内部错误，请重试。

					1003, // 系统错误。
				], true)) {
					return true;
				}
			}

			return false;
		}, function () use ($app) {
			return abs($app['config']->get('http.retry_delay', 500));
		});
	}

	/**
	 * Add a middleware.
	 *
	 * @param string $name
	 *
	 * @return $this
	 */
	protected function pushMiddleware(callable $middleware, string $name = null)
	{
		if (!is_null($name)) {
			$this->middlewares[$name] = $middleware;
		} else {
			array_push($this->middlewares, $middleware);
		}

		return $this;
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

		foreach ($this->middlewares as $name => $middleware) {
			$handlerStack->push($middleware, $name);
		}

		return $handlerStack;
	}
}
