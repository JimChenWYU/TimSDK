<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/18/2018
 * Time: 1:44 PM
 */

namespace TimSDK\Foundation\Log;

use TimSDK\Support\Arr;
use Psr\Log\LoggerInterface;
use Monolog\Logger as Monolog;
use Monolog\Handler\SyslogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\HandlerInterface;
use TimSDK\Container\ServiceContainer;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\SlackWebhookHandler;

class LogManager implements LoggerInterface
{
    /**
     * @var \TimSDK\Container\ServiceContainer $app
     */
    protected $app;

    /**
     * The array of resolved channels.
     *
     * @var array
     */
    protected $channels = [];

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * The Log levels.
     *
     * @var array
     */
    protected $levels = [
        'debug'     => Monolog::DEBUG,
        'info'      => Monolog::INFO,
        'notice'    => Monolog::NOTICE,
        'warning'   => Monolog::WARNING,
        'error'     => Monolog::ERROR,
        'critical'  => Monolog::CRITICAL,
        'alert'     => Monolog::ALERT,
        'emergency' => Monolog::EMERGENCY,
    ];

    /**
     * LogManager constructor.
     *
     * @param \TimSDK\Container\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * Create a new, on-demand aggregate logger instance.
     *
     * @param array       $channels
     * @param string|null $channel
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function stack(array $channels, $channel = null)
    {
        return $this->createStackDriver(compact('channels', 'channel'));
    }

    /**
     * Get a log channel instance.
     *
     * @param string|null $channel
     *
     * @return mixed
     */
    public function channel($channel = null)
    {
        return $this->get($channel);
    }

    /**
     * Get a log driver instance.
     *
     * @param null $driver
     * @return \Psr\Log\LoggerInterface
     */
    public function driver($driver = null)
    {
        return $this->get(isset($driver) ? $driver : $this->getDefaultDriver());
    }

    /**
     * Attempt to get the log from the local cache.
     *
     * @param string $name
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function get($name)
    {
        try {
            return Arr::get($this->channels, $name, $this->channels[$name] = $this->resolve($name));
        }
        // 兼容低于PHP7.0，不使用\Throwable
        catch (\InvalidArgumentException $e) {
            $logger = $this->createEmergencyLogger();
            $logger->emergency('Unable to create configured logger. Using emergency logger.', [
                'exception' => $e,
            ]);

            return $logger;
        }
    }

    /**
     * Resolve the given log instance by name.
     *
     * @param string $name
     *
     * @return \Psr\Log\LoggerInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->app['config']->get(\sprintf('log.channels.%s', $name));
        if (is_null($config)) {
            throw new \InvalidArgumentException(\sprintf('Log [%s] is not defined.', $name));
        }
        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($config);
        }
        $driverMethod = 'create' . ucfirst($config['driver']) . 'Driver';
        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        }
        throw new \InvalidArgumentException(\sprintf('Driver [%s] is not supported.', $config['driver']));
    }

    /**
     * Create an emergency log handler to avoid white screens of death.
     *
     * @return \Monolog\Logger
     */
    protected function createEmergencyLogger()
    {
        return new Monolog('TimSDK', $this->prepareHandlers([
            new StreamHandler(
                \sys_get_temp_dir() . '/tim-sdk/tim-sdk.log', $this->level(['level' => 'debug'])
            ),
        ]));
    }

    /**
     * Call a custom driver creator.
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config);
    }

    /**
     * Create an aggregate log driver instance.
     *
     * @param array $config
     *
     * @return \Monolog\Logger
     */
    protected function createStackDriver(array $config)
    {
        $handlers = [];
        foreach (Arr::get($config, 'channels', []) as $channel) {
            $handlers = \array_merge($handlers, $this->channel($channel)->getHandlers());
        }

        return new Monolog($this->parseChannel($config), $handlers);
    }

    /**
     * Create an instance of the single file log driver.
     *
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createSingleDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(
                new StreamHandler($config['path'], $this->level($config))
            ),
        ]);
    }

    /**
     * Create an instance of the daily file log driver.
     *
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createDailyDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new RotatingFileHandler(
                $config['path'], Arr::get($config, 'days', 7), $this->level($config)
            )),
        ]);
    }

    /**
     * Create an instance of the Slack log driver.
     *
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createSlackDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new SlackWebhookHandler(
                $config['url'],
                Arr::get($config, 'channel', null),
                Arr::get($config ,'username', 'TimSDK'),
                Arr::get($config ,'attachment', true),
                Arr::get($config ,'emoji', ':boom:'),
                Arr::get($config ,'short', false),
                Arr::get($config ,'context', true),
                $this->level($config)
            )),
        ]);
    }

    /**
     * Create an instance of the syslog log driver.
     *
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createSyslogDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new SyslogHandler(
                    'TimSDK', Arr::get($config, 'facility', LOG_USER), $this->level($config))
            ),
        ]);
    }

    /**
     * Create an instance of the "error log" log driver.
     *
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createErrorlogDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new ErrorLogHandler(
                Arr::get($config, 'type', ErrorLogHandler::OPERATING_SYSTEM), $this->level($config))
            ),
        ]);
    }

    /**
     * Prepare the handlers for usage by Monolog.
     *
     * @param array $handlers
     *
     * @return array
     */
    protected function prepareHandlers(array $handlers)
    {
        foreach ($handlers as $key => $handler) {
            $handlers[$key] = $this->prepareHandler($handler);
        }

        return $handlers;
    }

    /**
     * Prepare the handler for usage by Monolog.
     *
     * @param \Monolog\Handler\HandlerInterface $handler
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    protected function prepareHandler(HandlerInterface $handler)
    {
        return $handler->setFormatter($this->formatter());
    }

    /**
     * Get a Monolog formatter instance.
     *
     * @return \Monolog\Formatter\FormatterInterface
     */
    protected function formatter()
    {
        $formatter = new LineFormatter(null, null, true, true);
        $formatter->includeStacktraces();

        return $formatter;
    }

    /**
     * Extract the log channel from the given configuration.
     *
     * @param array $config
     *
     * @return string
     */
    protected function parseChannel(array $config)
    {
        return Arr::get($config, 'name', $this->getDefaultDriver());
    }

    /**
     * Parse the string level into a Monolog constant.
     *
     * @param array $config
     *
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    protected function level(array $config)
    {
        $level = Arr::get($config, 'level', 'debug');

        if (isset($this->levels[$level])) {
            return $this->levels[$level];
        }

        throw new \InvalidArgumentException('Invalid log level.');
    }

    /**
     * Get the default log driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['log.default'];
    }

    /**
     * Set the default log driver name.
     *
     * @param string $name
     * @return LogManager
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['log.default'] = $name;

        return $this;
    }

    /**
     * Add more channels
     *
     * @param array $channels
     * @return LogManager
     */
    public function addChannels(array $channels)
    {
        $original = $this->app['config']->get('log.channels', []);

        if (is_array($channels)) {
            $this->app['config']->set('log.channels', array_merge($original, $channels));
        }

        return $this;
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param string   $driver
     * @param \Closure $callback
     *
     * @return $this
     */
    public function extend($driver, \Closure $callback)
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @return mixed
     */
    public function emergency($message, array $context = [])
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->driver()->log($level, $message, $context);
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
//        return $this->driver()->$method(...$parameters);
        return call_user_func_array([$this->driver(), $method], $parameters);
    }
}
