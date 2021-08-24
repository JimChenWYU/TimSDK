<?php

namespace TimSDK\Kernel\Events;

use TimSDK\Kernel\ServiceContainer;

class ApplicationInitialized
{
    /**
     * @var \TimSDK\Kernel\ServiceContainer
     */
    public $app;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }
}
