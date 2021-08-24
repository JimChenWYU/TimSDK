<?php

namespace TimSDK\Kernel;

use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;
use TimSDK\Kernel\Exceptions\InvalidConfigException;
use TimSDK\Kernel\Support\Collection;
use TimSDK\Kernel\Traits\HasHttpRequests;

class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }

    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * BaseClient constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * GET request.
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * POST request.
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * JSON request.
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * @param bool $returnRaw
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }

        $response = $this->performRequest($url, $method, $this->castRequestQuery($options));

        return $returnRaw ? $response : $this->castResponseToType($response, 'collection');
    }

    /**
     * @param array $options
     * @return array
     * @throws Exceptions\InvalidArgumentException
     * @throws Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function castRequestQuery(array $options)
    {
        $options['query'] = array_merge([
            'ver' => 'v4',
            'identifier' => $this->app['config']->get('identifier'),
            'sdkappid' => $this->app['config']->get('app_id'),
            'usersig' => $this->app['usersig']->getUsersig(),
            'random' => random_int(0, 4294967295),
            'contenttype' => 'json',
        ], $options['query']);

        return $options;
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        // retry
        $this->pushMiddleware($this->retryMiddleware(), 'retry');
        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');
    }

    /**
     * Log the request.
     *
     * @return callable
     */
    protected function logMiddleware()
    {
        $formatter = new MessageFormatter($this->app['config']['http.log_template'] ?? MessageFormatter::DEBUG);

        return Middleware::log($this->app['logger'], $formatter, LogLevel::DEBUG);
    }

    /**
     * Return retry middleware.
     *
     * @return callable
     */
    protected function retryMiddleware()
    {
        return Middleware::retry(function (
            $retries,
            RequestInterface $request,
            ResponseInterface $response = null
        ) {
            // Limit the number of retries to 2
            if ($retries < $this->app['config']->get(
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
        }, function () {
            return abs($this->app['config']->get('http.retry_delay', 500));
        });
    }
}
