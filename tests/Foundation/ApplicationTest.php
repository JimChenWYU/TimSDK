<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/13/2018
 * Time: 8:02 PM
 */

namespace TimSDK\Tests\Foundation;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use TimSDK\Foundation\Application;
use TimSDK\Foundation\Config;
use TimSDK\Support\Log;
use TimSDK\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testContainer()
    {
        $app = new Application([
            'foo' => 'bar'
        ]);

        $this->assertEquals('bar', $app->config->get('foo'));
    }

    public function testConfig()
    {
        $config = new Config([
            'foo' => 1,
            'bar' => 2
        ]);

        $this->assertEquals(1, $config->get('foo'), 'Config Collection has not foo');
        $this->assertEquals(2, $config->get('bar'), 'Config Collection has not bar');
    }

    public function testLog()
    {
        $this->assertInstanceOf(LoggerInterface::class, Log::getLogger());

        $logger = Log::setLogger(new Logger('PHPUnit'));
        $this->assertSame(Log::getLogger(), $logger);
    }
}
