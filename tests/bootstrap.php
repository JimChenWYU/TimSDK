<?php

define('TEST_ROOT', __DIR__);
define('PROJECT_ROOT', rtrim(dirname(__DIR__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'src');

require __DIR__ . '/../vendor/autoload.php';

function phpunit_env($name, $default = null)
{
    $value = \TimSDK\Support\Arr::get(get_defined_constants(true), 'user.' . strtoupper($name), $default);

    return $value !== '0' && empty($value) ? $default : $value;
}
