<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:56 PM
 */

namespace TimSDK\Core;

use GuzzleHttp\Client;
use TimSDK\Container\ServiceContainer;
use TimSDK\Foundation\Application;

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
}
