<?php

namespace TimSDK\Kernel;

use TimSDK\Kernel\Contracts\UserSigInterface;
use TimSDK\Kernel\Exceptions\InvalidArgumentException;
use TimSDK\Kernel\Exceptions\RuntimeException;
use TimSDK\Kernel\Support\TLSSigAPIv2;
use TimSDK\Kernel\Traits\InteractWithCache;

abstract class UserSig implements UserSigInterface
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
    public function getUserSig(string $identifier, bool $refresh = false, int $expire = 86400 * 180): string
    {
        $cacheKey = $this->getCacheKey($identifier);
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey) && $result = $cache->get($cacheKey)) {
            return $result;
        }

        $usersig = $this->requestUsersig($identifier, $this->getCredentials(), $expire);

        $this->setUserSig($identifier, $usersig, $expire);

        $this->app->events->dispatch(new Events\UsersigRefreshed($this));

        return $usersig;
    }

    /**
     * @param int|float $expire
     * @return UserSigInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function refresh(string $identifier, int $expire = 86400 * 180): UserSigInterface
    {
        $this->getUserSig($identifier, true, $expire);

        return $this;
    }

	/**
	 * @param string $identifier
	 * @param string $userSig
	 * @param int    $expire
	 * @return UserSigInterface
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
    public function setUserSig(string $identifier, string $userSig, int $expire): UserSigInterface
    {
        $this->getCache()->set($this->getCacheKey($identifier), $userSig, $expire);

        if (!$this->getCache()->has($this->getCacheKey($identifier))) {
            throw new RuntimeException('Failed to cache usersig.');
        }

        return $this;
    }

	/**
	 * @param string $identifier
	 * @param array  $credentials
	 * @param int    $expire
	 * @return string
	 * @throws \Exception
	 */
    protected function requestUsersig(string $identifier, array $credentials, int $expire)
    {
        return (new TLSSigAPIv2($credentials['app_id'], $credentials['key']))->genUserSig(
	        $identifier,
            $expire
        );
    }

    /**
     * @return string
     */
    protected function getCacheKey(string $identifier)
    {
        return $this->cachePrefix.md5(json_encode(array_merge($this->getCredentials(), [
        	'identifier' => $identifier,
        ])));
    }

    /**
     * Credential for get token.
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}
