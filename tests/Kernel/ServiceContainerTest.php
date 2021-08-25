<?php

namespace TimSDK\Tests\Kernel;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use TimSDK\Kernel\BaseClient;
use TimSDK\Kernel\Config;
use TimSDK\Kernel\Log\LogManager;
use TimSDK\Kernel\ServiceContainer;
use TimSDK\Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testBasicFeatures()
    {
        $container = new ServiceContainer();

        $this->assertNotEmpty($container->getProviders());

        // __set, __get, offsetGet
        $this->assertInstanceOf(Config::class, $container['config']);
        $this->assertInstanceOf(Config::class, $container->config);

        $this->assertInstanceOf(Client::class, $container['http_client']);
        $this->assertInstanceOf(Request::class, $container['request']);
        $this->assertInstanceOf(LogManager::class, $container['log']);
        $this->assertInstanceOf(LogManager::class, $container['logger']);
        $this->assertInstanceOf(EventDispatcher::class, $container['events']);

        $container['foo'] = 'foo';
        $container->bar = 'bar';

        $this->assertSame('foo', $container['foo']);
        $this->assertSame('bar', $container['bar']);
    }

    public function testGetId()
    {
        $this->assertSame((new ServiceContainer(['app_id' => 'app-id1']))->getId(), (new ServiceContainer(['app_id' => 'app-id1']))->getId());
        $this->assertNotSame((new ServiceContainer(['app_id' => 'app-id1']))->getId(), (new ServiceContainer(['app_id' => 'app-id2']))->getId());
    }

    public function testRegisterProviders()
    {
        $container = new DummyContainerForProviderTest();

        $this->assertSame('foo', $container['foo']);
    }

    public function testMagicGetDelegation()
    {
        $container = \Mockery::mock(ServiceContainer::class);

        $container->shouldReceive('offsetGet')->andReturn(BaseClient::class);

        $this->assertSame(BaseClient::class, $container->config);
    }
}

class DummyContainerForProviderTest extends ServiceContainer
{
    protected $providers = [
        FooServiceProvider::class,
    ];
}

class FooServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['foo'] = function () {
            return 'foo';
        };
    }
}
