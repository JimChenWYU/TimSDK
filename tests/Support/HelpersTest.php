<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:04 AM
 */

namespace TimSDK\Tests\Support;

use TimSDK\Foundation\Application;
use TimSDK\Support\Collection;
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
        $this->assertInstanceOf(Collection::class, timsdk_app('config'));
    }
}
