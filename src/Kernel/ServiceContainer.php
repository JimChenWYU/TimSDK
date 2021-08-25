<?php

namespace TimSDK\Kernel;

use Pimple\Container;

/**
 * @property \TimSDK\Kernel\Config                              $config
 * @property \TimSDK\Kernel\Log\LogManager                      $log
 * @property \TimSDK\Kernel\Log\LogManager                      $logger
 * @property \Psr\Http\Client\ClientInterface                   $http_client
 * @property \Symfony\Component\HttpFoundation\Request          $request
 * @property \Symfony\Component\EventDispatcher\EventDispatcher $events
 */
class ServiceContainer extends Container
{
	/**
	 * The current globally available container (if any).
	 *
	 * @var static
	 */
	protected static $instance;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * Constructor.
     */
    public function __construct(array $config = [], array $prepends = [], string $id = null)
    {
        $this->userConfig = $config;

        parent::__construct($prepends);

        $this->id = $id;

	    static::setInstance($this);

        $this->registerProviders($this->getProviders());

	    $this->events->dispatch(new Events\ApplicationInitialized($this));
    }

	/**
	 * __destruct
	 */
	public function __destruct()
	{
		static::setInstance(null);
	}

	/**
     * @return string
     */
    public function getId()
    {
        return $this->id ?? $this->id = md5(json_encode($this->userConfig));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return array_replace_recursive($this->defaultConfig, $this->userConfig);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            Providers\ConfigServiceProvider::class,
            Providers\LogServiceProvider::class,
            Providers\RequestServiceProvider::class,
            Providers\HttpClientServiceProvider::class,
	        Providers\EventDispatcherServiceProvider::class,
        ], $this->providers);
    }

    /**
     * @param string $id
     * @param mixed  $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        if ($this->offsetExists($name)) {
            return $this->offsetGet($name) !== null;
        }

        return false;
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

	/**
	 * Get the globally available instance of the container.
	 *
	 * @return static
	 */
	public static function getInstance()
	{
		if (is_null(static::$instance)) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 * Set the shared instance of the container.
	 *
	 * @param  \Pimple\Container|null  $container
	 * @return \Pimple\Container|static
	 */
	public static function setInstance(Container $container = null)
	{
		return static::$instance = $container;
	}
}
