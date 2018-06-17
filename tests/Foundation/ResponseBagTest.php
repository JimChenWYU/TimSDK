<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/17/2018
 * Time: 9:41 AM
 */

namespace TimSDK\Tests\Foundation;

use TimSDK\Foundation\ResponseBag;
use TimSDK\Tests\TestCase;

class ResponseBagTest extends TestCase
{
    public function testResponseBagIsConstructed()
    {
        $bag = new ResponseBag('foo', 'bar');
        $this->assertSame(['foo'], $bag->getContents()->all());
        $this->assertSame(['bar'], $bag->getHeaders()->all());

        $bag = new ResponseBag('{"foo": "bar"}', '{"key": "value"}');
        $this->assertSame(['foo' => 'bar'], $bag->getContents()->all());
        $this->assertSame(['key' => 'value'], $bag->getHeaders()->all());

        $bag = new ResponseBag(
            new TestJsonSerializeObject(['foo' => 'bar']),
            new TestJsonSerializeObject(['key' => 'value'])
        );
        $this->assertSame(['foo' => 'bar'], $bag->getContents()->all());
        $this->assertSame(['key' => 'value'], $bag->getHeaders()->all());

        $bag = new ResponseBag(false, true);
        $this->assertSame([false], $bag->getContents()->all());
        $this->assertSame([true], $bag->getHeaders()->all());

        $bag = new ResponseBag(null, null);
        $this->assertSame([], $bag->getContents()->all());
        $this->assertSame([], $bag->getHeaders()->all());
    }
}

class TestJsonSerializeObject implements \JsonSerializable
{
    protected $items = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function jsonSerialize()
    {
        return $this->items;
    }
}
