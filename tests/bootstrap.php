<?php

define('TEST_ROOT', __DIR__);

require __DIR__ . '/../vendor/autoload.php';

function phpunit_env($name, $default = null)
{
    return \TimSDK\Support\Arr::get(get_defined_constants(true), 'user.' . strtoupper($name), $default);
}

if (! function_exists('dd')) {
    function dd()
    {
        var_dump(func_get_args());
    }
}
