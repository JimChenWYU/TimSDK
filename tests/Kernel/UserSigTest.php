<?php

namespace TimSDK\Tests\Kernel;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Simple\FilesystemCache;
use TimSDK\Kernel\Exceptions\RuntimeException;
use TimSDK\Kernel\ServiceContainer;
use TimSDK\Kernel\UserSig;
use TimSDK\Tests\TestCase;

class UserSigTest extends TestCase
{
    public function testCache()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $userSig = \Mockery::mock(UserSig::class, [$app])->makePartial();

        $this->assertInstanceOf(CacheInterface::class, $userSig->getCache());

        // prepended cache instance
        if (\class_exists('Symfony\Component\Cache\Psr16Cache')) {
            $cache = new ArrayAdapter();
        } else {
            $cache = new FilesystemCache();
        }

        $app['cache'] = function () use ($cache) {
            return $cache;
        };
        $userSig = \Mockery::mock(UserSig::class, [$app])->makePartial();

        $this->assertInstanceOf(CacheInterface::class, $userSig->getCache());
    }

    public function testGetUserSig()
    {
        $cache = \Mockery::mock(CacheInterface::class);
        $userSig = \Mockery::mock(UserSig::class.'[getCacheKey,getCache,requestUserSig,setUserSig,getCredentials]', [new ServiceContainer()])
            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];
        $identifier = 'admin';
        $userSig->allows()->getCredentials()->andReturn($credentials);
        $userSig->allows()->getCacheKey($identifier)->andReturn('mock-cache-key');
        $userSig->allows()->getCache()->andReturn($cache);

        $userSigResult = [
            'user_sig' => 'mock-cached-token',
            'expires_in' => 7200,
        ];


        // no refresh and cached
        $cache->expects()->has('mock-cache-key')->andReturn(true);
        $cache->expects()->get('mock-cache-key')->andReturn($userSigResult);

        $this->assertSame($userSigResult, $userSig->getUserSig($identifier, false, 7200));

        // no refresh and no cached
        $cache->expects()->has('mock-cache-key')->andReturn(false);
        $cache->expects()->get('mock-cache-key')->never();
        $userSig->expects()->requestUserSig($identifier, $credentials, 7200)->andReturn($userSigResult);
        $userSig->expects()->setUserSig($identifier, $userSigResult['user_sig'], $userSigResult['expires_in']);

        $this->assertSame($userSigResult, $userSig->getUserSig($identifier, false, 7200));

        // with refresh and cached
        $cache->expects()->has('mock-cache-key')->never();
        $userSig->expects()->requestUserSig($identifier, $credentials, 7200)->andReturn($userSigResult);
        $userSig->expects()->setUserSig($identifier, $userSigResult['user_sig'], $userSigResult['expires_in']);

        $this->assertSame($userSigResult, $userSig->getUserSig($identifier, true, 7200));
    }

    public function testSetUserSig()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $cache = \Mockery::mock(CacheInterface::class);
        $userSig = \Mockery::mock(UserSig::class.'[getCacheKey,getCache]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $identifier = 'admin';
        $userSig->allows()->getCacheKey($identifier)->andReturn('mock-cache-key');
        $userSig->allows()->getCache()->andReturn($cache);

        $cache->expects()->has('mock-cache-key')->andReturn(true);
        $cache->expects()->set('mock-cache-key', [
            'user_sig' => 'mock-token',
            'expires_in' => 7200,
        ], 7200)->andReturn(true);
        $result = $userSig->setUserSig($identifier, 'mock-token', 7200);
        $this->assertSame($userSig, $result);

        // 7000
        $cache->expects()->has('mock-cache-key')->andReturn(true);
        $cache->expects()->set('mock-cache-key', [
            'user_sig' => 'mock-token',
            'expires_in' => 7000,
        ], 7000)->andReturn(true);
        $result = $userSig->setUserSig($identifier, 'mock-token', 7000);
        $this->assertSame($userSig, $result);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed to cache usersig.');
        $cache->expects()->has('mock-cache-key')->andReturn(false);
        $cache->expects()->set('mock-cache-key', [
            'user_sig' => 'mock-token',
            'expires_in' => 7000,
        ], 7000)->andReturn(false);
        $userSig->setUserSig($identifier, 'mock-token', 7000);
    }

    public function testRefresh()
    {
        $app = \Mockery::mock(ServiceContainer::class);
        $userSig = \Mockery::mock(UserSig::class.'[getUserSig]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $identifier = 'admin';
        $userSig->expects()->getUserSig($identifier, true, 7000);

        $result = $userSig->refresh($identifier, 7000);

        $this->assertSame($userSig, $result);
    }

    public function testGetCacheKey()
    {
        $app = \Mockery::mock(ServiceContainer::class)->makePartial();
        $userSig = \Mockery::mock(UserSig::class.'[getCacheKey,getCredentials]', [$app])
            ->shouldAllowMockingProtectedMethods();
        $credentials = [
            'appid' => '123',
            'secret' => 'pa33w0rd',
        ];
        $identifier = 'admin';
        $userSig->allows()->getCredentials()->andReturn($credentials);
        $userSig->expects()->getCacheKey($identifier)->passthru();

        $this->assertStringEndsWith(md5(json_encode(array_merge($credentials, [
            'identifier' => $identifier,
        ]))), $userSig->getCacheKey($identifier));
    }
}
