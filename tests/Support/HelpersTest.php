<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:04 AM
 */

namespace TimSDK\Tests\Support;

use Monolog\Logger;
use TimSDK\Foundation\Application;
use TimSDK\Tests\TestCase;

class HelpersTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals('foo', timsdk_value('foo'));
        $this->assertEquals('foo', timsdk_value(function () {
            return 'foo';
        }));
    }

    public function testApp()
    {
        $this->assertInstanceOf(Application::class, timsdk_app());
        $this->assertInstanceOf(Logger::class, timsdk_app('log'));
    }
}
