<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/23/2018
 * Time: 8:13 PM
 */

namespace TimSDK\Core;

use TimSDK\Support\Collection;

class ApiAlias extends Collection
{
    public function __construct()
    {
        $reflectionObject = new \ReflectionClass(API::class);
        parent::__construct($reflectionObject->getConstants());
    }

    public function get($key, $default = null)
    {
        $value = parent::get($key, $default);

        return is_null($value) ? $key : $value;
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}
