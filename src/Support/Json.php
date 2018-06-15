<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 2:43 PM
 */
namespace TimSDK\Support;

use TimSDK\Core\Exceptions\JsonParseException;

class Json
{
    /**
     * Returns the JSON representation of a value
     *
     * @static
     * @param mixed $value
     * @param int   $options
     * @param int   $depth
     * @return string
     * @throws JsonParseException
     */
    public static function encode($value, $options = 0, $depth = 512)
    {
        $json = \json_encode($value, $options, $depth);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonParseException(
                'json_encode error: ' . json_last_error_msg(),
                json_last_error()
            );
        }

        return $json;
    }

    /**
     * Decodes a JSON string
     *
     * @static
     * @param string $json
     * @param bool   $assoc
     * @param int    $depth
     * @param int    $options
     * @return mixed
     * @throws JsonParseException
     */
    public static function decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        $data = \json_decode($json, $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonParseException(
                'json_decode error: ' . json_last_error_msg(),
                json_last_error()
            );
        }

        return $data;
    }
}
