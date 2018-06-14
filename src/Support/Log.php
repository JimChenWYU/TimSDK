<?php
namespace TimSDK\Support;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;
use Monolog\Logger as Monolog;
use Psr\Log\LoggerInterface;

/**
 * Class Log
 *
 * @method static debug($message, $context = null)
 * @method static info($message, $context = null)
 * @method static notice($message, $context = null)
 * @method static warning($message, $context = null)
 * @method static error($message, $context = null)
 * @method static critical($message, $context = null)
 * @method static alert($message, $context = null)
 * @method static emergency($message, $context = null)
 * @package TimSDK\Support
 */
class Log
{
    protected static $logger;

    /**
     * Return the logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger()
    {
        return self::$logger ?: self::$logger = self::createDefaultLogger();
    }

    /**
     * Set logger.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;

        return self::$logger;
    }

    /**
     * Tests if logger exists.
     *
     * @return bool
     */
    public static function hasLogger()
    {
        return self::$logger ? true : false;
    }

    /**
     * Make a default log instance.
     *
     * @return \Monolog\Logger
     */
    private static function createDefaultLogger()
    {
        $log = new Monolog('TimSDK');

        if (defined('PHPUNIT_RUNNING') || 'cli' === php_sapi_name()) {
            $log->pushHandler(new NullHandler());
        } else {
            $log->pushHandler(new ErrorLogHandler());
        }

        return $log;
    }

    /**
     * Forward call.
     *
     * @param string $method
     * @param array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([self::getLogger(), $method], $arguments);
    }

    /**
     * Forward call.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return forward_static_call_array([self::getLogger(), $method], $arguments);
    }
}
