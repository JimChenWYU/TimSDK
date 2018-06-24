<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:04 AM
 */

namespace TimSDK\Tests;

use TimSDK\Container\ServiceContainer;
use TimSDK\Support\Collection;

class HelpersTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals('foo', \TimSDK\value('foo'));
        $this->assertEquals('foo', \TimSDK\value(function () {
            return 'foo';
        }));
    }

    public function testApp()
    {
        $this->assertInstanceOf(ServiceContainer::class, \TimSDK\app());
        $this->assertInstanceOf(Collection::class, \TimSDK\app('config'));
    }
}
