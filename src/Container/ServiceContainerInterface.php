<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/19/2018
 * Time: 1:43 PM
 */

namespace TimSDK\Container;

interface ServiceContainerInterface
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
