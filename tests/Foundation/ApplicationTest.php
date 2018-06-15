<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/13/2018
 * Time: 8:02 PM
 */

namespace TimSDK\Tests\Foundation;

use Monolog\Logger;
use Pimple\Container;
use TimSDK\Container\ServiceContainer;
use TimSDK\Foundation\Application;
use TimSDK\Foundation\ServiceProviders\ServiceProvider;
use TimSDK\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testContainerBinding()
    {
        $app = new Application([
            'foo' => 'bar',
        ], [
            'bar' => function () {
                return new \stdClass();
            },
            'name' => 'TimSDK',
            'foo'  => 'Jim'
        ]);

        $app['foo'] = function () {
            return 'bar';
        };

        $this->assertEquals('bar', $app['foo']);
        $this->assertEquals('TimSDK', $app['name']);
        $this->assertInstanceOf(\stdClass::class, $app['bar']);
        $this->assertSame($app['bar'], $app['bar']);
    }

    public function testContainerServiceProvider()
    {
        $app = new SampleApplication();

        $this->assertEquals('foo', $app['bar']);
        $this->assertInstanceOf(\stdClass::class, $app['foo']);
        $this->assertSame($app['foo'], $app['foo']);
    }

    public function testContainerConfig()
    {
        $app = new Application([
            'foo' => 'bar',
        ]);

        $this->assertEquals('bar', $app['config']->get('foo'));
    }

    public function testGetContainerSelf()
    {
        $app = new Application();

        $this->assertInstanceOf(ServiceContainer::class, $app['app']);
        $this->assertInstanceOf(ServiceContainer::class, $app[ServiceContainer::class]);
    }

    public function testGetLogService()
    {
        $app = new Application();

        $this->assertInstanceOf(Logger::class, $app['log']);
        $this->assertInstanceOf(Logger::class, $app['logger']);
    }
}

class SampleApplication extends Application
{
    protected $providers = [
        SampleServiceProvider::class
    ];
}

class SampleServiceProvider extends ServiceProvider
{
    public function register(Container $pimple)
    {
        $pimple['bar'] = function () {
            return 'foo';
        };

        $pimple['foo'] = function () {
            return new \stdClass();
        };
    }
}
