<?php

use TimSDK\Container\ServiceContainer;
use TimSDK\Support\Dumper;

/**
 * Return the default value of the given value.
 *
 * @param  mixed  $value
 * @return mixed
 */
function timsdk_value($value)
{
    return $value instanceof \Closure ? $value() : $value;
}

/**
 * Get the available container instance.
 *
 * @param string $abstract
 * @return mixed|static
 */
function timsdk_app($abstract = null)
{
    if (is_null($abstract)) {
        return ServiceContainer::getInstance();
    }

    return ServiceContainer::getInstance()->offsetGet($abstract);
}

/**
 * Dump the passed variables and end the script.
 */
function timsdk_dd()
{
    foreach (func_get_args() as $arg) {
        (new Dumper)->dump($arg);
    }

    die(1);
}

function timsdk_d()
{
    foreach (func_get_args() as $arg) {
        (new Dumper)->dump($arg);
    }
}
