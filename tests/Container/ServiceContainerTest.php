<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/19/2018
 * Time: 1:56 PM
 */

namespace TimSDK\Tests\Container;

use Pimple\Container;
use GuzzleHttp\Client;
use TimSDK\Tests\TestCase;
use TimSDK\Foundation\Config;
use Pimple\ServiceProviderInterface;
use TimSDK\Foundation\Log\LogManager;
use TimSDK\Container\ServiceContainer;

class ServiceContainerTest extends TestCase
{
    public function testBasicFeatures()
    {
        $container = new ServiceContainer();
        $this->assertNotEmpty($container->getProviders());
        // __set, __get, offsetGet
        $this->assertInstanceOf(Config::class, $container['config']);
        $this->assertInstanceOf(Config::class, $container->config);
        $this->assertInstanceOf(Client::class, $container['httpClient']);
        $this->assertInstanceOf(Client::class, $container->httpClient);
        $this->assertInstanceOf(Client::class, $container[Client::class]);
        $this->assertInstanceOf(LogManager::class, $container['log']);
        $this->assertInstanceOf(LogManager::class, $container->log);
        $container['foo'] = 'foo';
        $container->bar = 'bar';
        $this->assertSame('foo', $container['foo']);
        $this->assertSame('bar', $container['bar']);
    }

    public function testRegisterProviders()
    {
        $container = new DummyContainerForProviderTest();
        $this->assertSame('foo', $container['foo']);
    }

    public function testStaticInstance()
    {
        $app = new ServiceContainer();
        ServiceContainer::setInstance($app);
        $this->assertEquals($app, ServiceContainer::getInstance());
    }

    public function testInstanceMethod()
    {
        $app = new ServiceContainer();
        $app->instance('foo', 'bar');
        $this->assertSame('bar', $app['foo']);
    }

    public function testGetConfig()
    {
        $app = new ServiceContainer([
            'foo' => 'bar'
        ]);

        $config = $app->getConfig();

        $this->assertInternalType('array', $app->getConfig());
        $this->assertSame('bar', $config['foo']);
    }

    public function testBasePath()
    {
        $app = new ServiceContainer();

        $this->assertSame(PROJECT_ROOT, $app->basePath());
        $this->assertSame(PROJECT_ROOT . DIRECTORY_SEPARATOR . 'Cert', $app->basePath('Cert'));
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
