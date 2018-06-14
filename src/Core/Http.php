<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/13/2018
 * Time: 12:29 AM
 */

namespace TimSDK\Core;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use TimSDK\Core\Exceptions\HttpException;
use TimSDK\Support\Log;

class Http
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var array
     */
    protected static $globals = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    /**
     * @var array
     */
    protected static $defaults = [];

    /**
     * POST request.
     *
     * @param string $url
     * @param array  $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function post($url, $params = [])
    {
        $key = is_array($params) ? 'form_params' : 'body';

        return $this->request($url, 'POST', [$key => $params]);
    }

    /**
     * Return current guzzle default settings.
     *
     * @return array
     */
    public static function getDefaultOptions()
    {
        return self::$defaults;
    }

    /**
     * Set guzzle default settings.
     *
     * @param array $defaults
     */
    public static function setDefaultOptions($defaults)
    {
        self::$defaults = array_merge(self::$globals, $defaults);
    }

    /**
     * Get http client
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if (!($this->client instanceof HttpClient)) {
            $this->client = new HttpClient();
        }

        return $this->client;
    }

    /**
     * Set http client
     *
     * @param HttpClient $client
     * @return Http
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Make a request.
     *
     * @param string $url
     * @param string $method
     * @param array  $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function request($url, $method = 'GET', $options = [])
    {
        $method = strtoupper($method);

        $options = array_merge(self::$defaults, $options);

        Log::debug('Client Request:', compact('url', 'method', 'options'));

        $response = $this->getClient()->request($method, $url, $options);

        Log::debug('API response:', [
            'Status' => $response->getStatusCode(),
            'Reason' => $response->getReasonPhrase(),
            'Headers' => $response->getHeaders(),
            'Body' => strval($response->getBody()),
        ]);

        return $response;
    }

    /**
     * Parse json string
     *
     * @param $body
     * @return bool|mixed
     * @throws HttpException
     */
    public function parseJSON($body)
    {
        if ($body instanceof ResponseInterface) {
            $body = $body->getBody();
        }

        if (empty($body)) {
            return false;
        }

        $contents = json_decode($body, true);

        Log::debug('API response decoded:', compact('contents'));

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new HttpException('Failed to parse JSON: '.json_last_error_msg());
        }

        return $contents;
    }
}
