<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/12/2018
 * Time: 11:58 PM
 */

namespace TimSDK\Foundation;

use TimSDK\Core\Http;
use Illuminate\Container\Container;
use TimSDK\Foundation\ServiceProviders\ServiceProvider;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use TimSDK\Support\Log;

/**
 * Class Application
 * @package TimSDK\Foundation
 * @property Config $config
 */
class Application extends Container implements ApplicationContract
{
    /**
     * version.
     *
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * The base path for the Laravel installation.
     *
     * @var string
     */
    protected $basePath;

    protected $providers = [
        //
    ];

    protected $bootstrappers = [
        //
    ];

    public function __construct($config)
    {
        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        $this->registerBaseBindings();

        $this->registerProviders();

        $this->bootstrapWith($this->bootstrappers);

        $this->initializeGuzzle();

        $this->logConfiguration($config);
    }

    /**
     * Init Guzzle
     */
    protected function initializeGuzzle()
    {
        Http::setDefaultOptions($this['config']->get('guzzle', ['timeout' => 5.0]));
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance(Container::class, $this);
    }

    /**
     * Register all service
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider($this));
        }
    }

    /**
     * Log configuration.
     *
     * @param array $config
     */
    public function logConfiguration($config)
    {
        $config = new Config($config);

        $keys = ['appid', 'account_type'];

        foreach ($keys as $key) {
            !$config->has($key) || $config[$key] = '***' . substr($config[$key], -5);
        }

        Log::debug('Current config:', $config->toArray());
    }

    /**
     * Register a service provider with the application.
     *
     * @param       $provider
     * @param array $options
     * @param bool  $force
     * @return ServiceProvider
     */
    public function register($provider, $options = [], $force = false)
    {
        if (is_string($provider)) {
            $provider = new $provider();
        }

        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        return $provider;
    }

    /**
     * Boot a service
     *
     * @param array $bootstrappers
     */
    public function bootstrapWith(array $bootstrappers)
    {
        foreach ($bootstrappers as $bootstrapper) {
            $this->make($bootstrapper)->bootstrap($this);
        }
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
     * Get the base path of the Laravel installation.
     *
     * @param string $path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get or check the current application environment.
     *
     * @param  mixed
     * @return string
     */
    public function environment()
    {
    }

    /**
     * Determine if the application is currently down for maintenance.
     *
     * @return bool
     */
    public function isDownForMaintenance()
    {
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
    }

    /**
     * Register a deferred provider and service.
     *
     * @param  string $provider
     * @param  string $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null)
    {
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register a new boot listener.
     *
     * @param  mixed $callback
     * @return void
     */
    public function booting($callback)
    {
    }

    /**
     * Register a new "booted" listener.
     *
     * @param  mixed $callback
     * @return void
     */
    public function booted($callback)
    {
    }

    /**
     * Get the path to the cached "compiled.php" file.
     *
     * @return string
     */
    public function getCachedCompilePath()
    {
    }

    /**
     * Get the path to the cached services.json file.
     *
     * @return string
     */
    public function getCachedServicesPath()
    {
    }
}
