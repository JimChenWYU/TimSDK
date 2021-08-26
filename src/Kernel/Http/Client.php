<?php

namespace TimSDK\Kernel\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client extends GuzzleClient implements ClientInterface
{
    /**
     * 兼容 Guzzle 6.x
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if (is_callable('parent::sendRequest')) {
            return parent::sendRequest($request);
        }

        $options[RequestOptions::SYNCHRONOUS] = true;
        $options[RequestOptions::ALLOW_REDIRECTS] = false;
        $options[RequestOptions::HTTP_ERRORS] = false;

        return $this->sendAsync($request, $options)->wait();
    }
}
