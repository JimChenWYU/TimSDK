<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:56 PM
 */

namespace TimSDK\Core;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use TimSDK\Support\Arr;
use TimSDK\Support\Collection;
use TimSDK\Foundation\Application;
use TimSDK\Container\ServiceContainer;
use TimSDK\Core\Exceptions\HttpException;
use TimSDK\Support\Json;

abstract class AbstractTimSDKAPI
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Client
     */
    protected $httpClient;

    const POST = 'post';
    const JSON = 'json';

    /**
     * AbstractTimSDKAPI constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;

        if (isset($app['httpClient'])) {
            $this->httpClient = $app['httpClient'];
        }

        $this->initialize();
    }

    /**
     * Init
     */
    public function initialize()
    {
    }

    /**
     * Set the httpClient
     *
     * @param Client $httpClient
     * @return Client
     */
    public function setHttpClient($httpClient)
    {
        return $this->httpClient = $httpClient;
    }

    /**
     * Parse JSON from response and check error.
     *
     * @param string $method
     * @param array  $args
     *
     * @return Collection
     * @throws HttpException
     * @throws Exceptions\JsonParseException
     */
    public function parseJSON($method, array $args)
    {
        /**
         * @var ResponseInterface $response
         */
        $response = call_user_func_array([$this->httpClient, $method], $args);
        $contents = $this->resolveResponse($response);
        $this->checkAndThrow($contents);

        return new Collection($contents);
    }

    /**
     * Resolve Guzzle Response
     *
     * @param $response
     * @return array
     * @throws Exceptions\JsonParseException
     */
    protected function resolveResponse($response)
    {
        if ($response instanceof ResponseInterface) {
            $response = $response->getBody();
        }

        return Json::decode($response, true);
    }

    /**
     * Check the array data errors, and Throw exception when the contents contains error.
     *
     * @param array $contents
     *
     * @throws HttpException
     */
    protected function checkAndThrow(array $contents)
    {
        if (isset($contents['ErrorCode']) && 0 !== $contents['ErrorCode']) {
            if (empty($contents['ErrorInfo'])) {
                $contents['ErrorInfo'] = 'Unknown';
            }
            throw new HttpException($contents['ErrorInfo'], $contents['ErrorCode']);
        }
    }
}
