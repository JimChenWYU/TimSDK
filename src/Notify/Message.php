<?php

namespace TimSDK\Notify;

use Closure;
use Symfony\Component\HttpFoundation\JsonResponse;
use TimSDK\Kernel\Exceptions\Exception;

class Message
{
    public const OK = 'OK';
    public const FAIL = 'FAIL';

    /**
     * @var \TimSDK\Application
     */
    protected $app;
    /**
     * @var string
     */
    protected $fail = '';
    /**
     * @var int
     */
    protected $errCode = 0;
    /**
     * @var array
     */
    protected $attributes = [];
    /**
     * @var array
     */
    protected $message;
    /**
     * @var array
     */
    protected $query;

    /**
     * MessageNotify constructor.
     * @param \TimSDK\Application $app
     */
    public function __construct(\TimSDK\Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $message
     */
    public function fail(string $message, int $errCode = 1)
    {
        $this->fail = $message;
        $this->errCode = $errCode;
    }

    /**
     * @return $this
     */
    public function respondWith(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return array|mixed
     * @throws \TimSDK\Kernel\Exceptions\Exception
     */
    public function getMessage()
    {
        if (!empty($this->message)) {
            return $this->message;
        }

        $message = \json_decode($this->app['request']->getContent(), true);

        if (!\is_array($message) || empty($message)) {
            throw new Exception('Invalid request Body JSON.', 400);
        }

        return $this->message = $message;
    }

    /**
     * @return array
     * @throws \TimSDK\Kernel\Exceptions\Exception
     */
    public function getQuery()
    {
        if (!empty($this->query)) {
            return $this->query;
        }

        $query = [];
        parse_str($this->app['request']->getQueryString(), $query);

        if (!\is_array($query) || empty($query)) {
            throw new Exception('Invalid request Query JSON.', 400);
        }

        return $this->query = $query;
    }

    /**
     * @param \Closure $closure
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \TimSDK\Kernel\Exceptions\Exception
     */
    public function handle(Closure $closure)
    {
        $this->strict(
            \call_user_func($closure, $this->getMessage(), $this->getQuery(), [$this, 'fail'])
        );

        return $this->toResponse();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function toResponse(): JsonResponse
    {
        $base = [
            'ActionStatus' => $this->errCode === 0 ? static::OK : static::FAIL,
            'ErrorCode' => $this->errCode,
            'ErrorInfo' => $this->fail,
        ];

        $attributes = array_merge($base, $this->attributes);

        return new JsonResponse(json_encode($attributes));
    }

    /**
     * @param mixed $result
     */
    protected function strict($result)
    {
        if (true !== $result && empty($this->fail)) {
            $this->fail((string)$result);
        }
    }
}
