<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/12/2018
 * Time: 11:58 PM
 */

namespace TimSDK\Foundation;

use TimSDK\Service\API;
use TimSDK\Support\Log;
use TimSDK\Container\ServiceContainer;
use TimSDK\Container\ApplicationInterface as ContractContainer;

/**
 * Class Application
 * @package TimSDK\Foundation
 * @property \TimSDK\Foundation\Config $config
 * @property \GuzzleHttp\Client $httpClient
 */
class Application extends ServiceContainer implements ContractContainer
{
    /**
     * version.
     *
     * @var string
     */
    const VERSION = '0.0.1';

    protected $basePath;

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * @var array
     */
    protected $providers = [
        //
    ];

    public function __construct(array $config = [], array $prepends = [])
    {
        $this->userConfig = $config;

        $this->registerBaseBindings();

        $this->registerProviders();

        $this->logConfiguration();

        parent::__construct($prepends);
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
    }

    /**
     * Get the base path
     *
     * @param  string  $path Optionally, a path to append to the base path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $base = [
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'http' => [
                'timeout' => 5.0,
                'base_uri' => API::BASE_URL,
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Register all service
     */
    protected function registerProviders()
    {
        foreach ($this->getProviders() as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * Get all providers
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            \TimSDK\Foundation\ServiceProviders\LogServiceProvider::class,
            \TimSDK\Foundation\ServiceProviders\ConfigServiceProvider::class,
            \TimSDK\Foundation\ServiceProviders\HttpClientServiceProvider::class,
        ], $this->providers);
    }

    /**
     * @param ServiceContainer $instance
     * @return ServiceContainer
     */
    public static function setInstance(ServiceContainer $instance = null)
    {
        return self::$instance = $instance;
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    public function registerBaseBindings()
    {
        self::setInstance($this);

        $this->instance(ServiceContainer::class, $this);

        $this->instance('app', $this);
    }

    /**
     * Log Configuration
     */
    protected function logConfiguration()
    {
        $config = new Config($this->getConfig());

        foreach (['sdkappid', 'account_type'] as $item) {
            $config->has($item) && $config->set($item, substr($config->get($item), 0, 5) . '...');
        }

        Log::debug('Current config:', $config->toArray());
    }
}
