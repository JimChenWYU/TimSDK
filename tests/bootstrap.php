<?php

define('TEST_ROOT', __DIR__);
define('PROJECT_ROOT', rtrim(dirname(__DIR__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'src');

require __DIR__ . '/../vendor/autoload.php';

function phpunit_env($name, $default = null)
{
    return \TimSDK\Support\Arr::get(get_defined_constants(true), 'user.' . strtoupper($name), $default);
}

if (!function_exists('dd')) {
    function dd()
    {
        call_user_func_array('timsdk_dd', func_get_args());
    }
}

if (!function_exists('d')) {
    function d()
    {
        call_user_func_array('timsdk_d', func_get_args());
    }
}
