<?php
namespace TimSDK\Support;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;
use Monolog\Logger as Monolog;
use Psr\Log\LoggerInterface;
use TimSDK\Core\Exceptions\NotInstantiableException;

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
    private function __construct()
    {
        throw new NotInstantiableException(__CLASS__ . ' can not instantiate.');
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
        return forward_static_call_array([\TimSDK\app('log'), $method], $arguments);
    }
}
