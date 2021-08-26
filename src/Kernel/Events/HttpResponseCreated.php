<?php

namespace TimSDK\Kernel\Events;

use Psr\Http\Message\ResponseInterface;

class HttpResponseCreated
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    public $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
