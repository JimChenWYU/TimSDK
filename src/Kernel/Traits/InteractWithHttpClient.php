<?php

namespace TimSDK\Kernel\Traits;

use Nyholm\Psr7;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use InvalidArgumentException;
use TimSDK\Kernel\ServiceContainer;

trait InteractWithHttpClient
{
    use ResponseCastable;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected static $defaults = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    /**
     * Set guzzle default settings.
     *
     * @param array $defaults
     */
    public static function setDefaultOptions($defaults = [])
    {
        self::$defaults = $defaults;
    }

    /**
     * Return current guzzle default settings.
     */
    public static function getDefaultOptions(): array
    {
        return self::$defaults;
    }

    /**
     * Set Psr\Http\Client\ClientInterface implementation.
     *
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return \Psr\Http\Client\ClientInterface.
     */
    public function getHttpClient(): ClientInterface
    {
        if (!($this->httpClient instanceof ClientInterface)) {
            if (property_exists($this, 'app') && $this->app['http_client']) {
                $this->httpClient = $this->app['http_client'];
            } else {
            	$this->httpClient = ServiceContainer::getInstance()->http_client;
            }
        }

        return $this->httpClient;
    }

    /**
     * Make a request.
     *
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($url, $method = 'GET', $options = []): ResponseInterface
    {
        $method = strtoupper($method);

        $options = array_merge(self::$defaults, $options);

        $options = $this->fixJsonIssue($options);

        if (property_exists($this, 'baseUri') && !is_null($this->baseUri)) {
            $options['base_uri'] = $this->baseUri;
        }

	    $headers = $options['headers'] ?? [];
	    $body = $options['body'] ?? null;
	    $version = $options['version'] ?? '1.1';
        $response = $this->getHttpClient()->sendRequest(new Psr7\Request($method, $url, $headers, $body, $version));
        $response->getBody()->rewind();

        return $response;
    }

	/**
	 * @param array $options
	 * @return array
	 */
    protected function fixJsonIssue(array $options): array
    {
        if (isset($options['json']) && is_array($options['json'])) {
            $options['headers'] = array_merge($options['headers'] ?? [], ['Content-Type' => 'application/json']);

            if (empty($options['json'])) {
                $options['body'] = json_encode($options['json'], JSON_FORCE_OBJECT);
            } else {
                $options['body'] = json_encode($options['json'], JSON_UNESCAPED_UNICODE);
            }

	        if (\JSON_ERROR_NONE !== \json_last_error()) {
		        throw new InvalidArgumentException('json_encode error: ' . \json_last_error_msg());
	        }

            unset($options['json']);
        }

        return $options;
    }
}
