<?php

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
