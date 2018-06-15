<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 12:57 PM
 */

namespace TimSDK\Container;

interface ApplicationInterface
{
    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version();

    /**
     * @return array
     */
    public function getConfig();
}
