<?php

namespace TimSDK\Kernel;

use Psr\Http\Message\ResponseInterface;
use TimSDK\Kernel\Exceptions\InvalidConfigException;
use TimSDK\Kernel\Support\Collection;
use TimSDK\Kernel\Traits\InteractWithHttpClient;

class BaseClient
{
    use InteractWithHttpClient {
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
        $response = $this->performRequest($url, $method, $this->castRequestQuery($options));

        $this->app->events->dispatch(new Events\HttpResponseCreated($response));

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
}
