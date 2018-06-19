<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:56 PM
 */

namespace TimSDK\Core;

use TimSDK\Support\Json;
use TimSDK\Foundation\ResponseBag;
use TimSDK\Container\ServiceContainer;
use Psr\Http\Message\ResponseInterface;

class BaseIMCloud
{
    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * AbstractTimSDKAPI constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;

        $this->initialize();
    }

    /**
     * Init
     */
    public function initialize()
    {
    }

    /**
     * POST request.
     *
     * @param       $uri
     * @param array $data
     * @param array $options
     * @return ResponseBag
     */
    public function httpPost($uri, $data = [], $options = [])
    {
        return $this->request($uri, 'POST', array_merge($options, [
            'form_params' => $data
        ]));
    }

    /**
     * JSON request.
     *
     * @param       $uri
     * @param array $data
     * @param array $options
     * @return ResponseBag
     * @throws Exceptions\JsonParseException
     */
    public function httpPostJson($uri, $data = [], $options = [])
    {
        return $this->request($uri, 'POST', array_merge($options, [
            'body' => is_array($data) ? Json::encode($data) : $data
        ]));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return ResponseBag
     */
    public function request($uri, $method = 'GET', $options = [])
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->app->httpClient->request($method, $uri, $options);

        return new ResponseBag(
            $response->getBody()->getContents(),
            $response->getHeaders(),
            $response->getStatusCode()
        );
    }
}
