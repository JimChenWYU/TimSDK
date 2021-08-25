<?php

namespace TimSDK\Kernel;

use Psr\Http\Message\ResponseInterface;
use TimSDK\Kernel\Contracts\UserSigInterface;
use TimSDK\Kernel\Exceptions\InvalidConfigException;
use TimSDK\Kernel\Support\Arr;
use TimSDK\Kernel\Support\Collection;
use TimSDK\Kernel\Traits\InteractWithHttpClient;
use TimSDK\Kernel\Traits\InteractWithIdentifier;

class BaseClient
{
    use InteractWithHttpClient {
        request as performRequest;
    }
    use InteractWithIdentifier;

    /**
     * @var \TimSDK\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @var \TimSDK\Kernel\Contracts\UserSigInterface
     */
    protected $userSig;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * BaseClient constructor.
     * @param ServiceContainer      $app
     * @param UserSigInterface|null $userSig
     */
    public function __construct(ServiceContainer $app, UserSigInterface $userSig = null)
    {
        $this->app = $app;
        $this->userSig = $userSig ?? $this->app['user_sig'];
    }

    /**
     * GET request.
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * JSON request.
     *
     * @return Collection
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
     * @return ResponseInterface|Collection
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
        $identifier = $this->getIdentifier();
        $options['query'] = array_merge([
            'ver' => 'v4',
            'sdkappid' => $this->app->config->get('app_id'),
            'identifier' => $identifier,
            'usersig' => $this->getUserSigString($identifier),
            'random' => random_int(0, 4294967295),
            'contenttype' => 'json',
        ], $options['query']);

        return $options;
    }

    /**
     * @param string $identifier
     * @return string
     */
    protected function getUserSigString(string $identifier): string
    {
        return Arr::get($this->userSig->getUserSig($identifier), 'user_sig', '');
    }
}
