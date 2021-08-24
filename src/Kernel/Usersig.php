<?php

namespace TimSDK\Kernel;

use TimSDK\Kernel\Contracts\UsersigInterface;
use TimSDK\Kernel\Exceptions\InvalidArgumentException;
use TimSDK\Kernel\Exceptions\RuntimeException;
use TimSDK\Kernel\Support\TLSSigAPIv2;
use TimSDK\Kernel\Traits\InteractWithCache;

class Usersig implements UsersigInterface
{
    use InteractWithCache;

    /**
     * @var \TimSDK\Kernel\ServiceContainer
     */
    protected $app;


    /**
     * @var string
     */
    protected $cachePrefix = 'timsdk.kernel.usersig.';

    /**
     * AccessToken constructor.
     *
     * @param \TimSDK\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param bool $refresh
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getUsersig(bool $refresh = false, int $expire = 86400 * 180): string
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey) && $result = $cache->get($cacheKey)) {
            return $result;
        }

        $usersig = $this->requestUsersig($this->getCredentials(), $expire);

        $this->setUsersig($usersig, $expire);

	    $this->app->events->dispatch(new Events\UsersigRefreshed($this));

        return $usersig;
    }

    /**
     * @param int|float $expire
     * @return UsersigInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function refresh(int $expire = 86400 * 180): UsersigInterface
    {
        $this->getUsersig(true, $expire);

        return $this;
    }

    /**
     * @param string $usersig
     * @param int    $expire
     * @return UsersigInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setUsersig(string $usersig, int $expire): UsersigInterface
    {
        $this->getCache()->set($this->getCacheKey(), $usersig, $expire);

        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache usersig.');
        }

        return $this;
    }

    /**
     * @param array $credentials
     * @return string
     * @throws \Exception
     */
    protected function requestUsersig(array $credentials, int $expire)
    {
        return (new TLSSigAPIv2($credentials['app_id'], $credentials['key']))->genUserSig(
            $credentials['user_id'],
            $expire
        );
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
    }

    /**
     * Credential for get token.
     *
     * @return array
     */
    protected function getCredentials(): array
    {
        return [
            'app_id' => $this->app['config']->get('app_id'),
            'key' => $this->app['config']->get('key'),
        ];
    }
}
