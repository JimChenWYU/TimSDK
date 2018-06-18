<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:07 AM
 */

namespace TimSDK\Tests\Support;

use ArrayAccess;
use JsonSerializable;
use ReflectionClass;
use TimSDK\Support\Collection;
use TimSDK\Tests\TestCase;

class CollectionTest extends TestCase
{
    public function testCollectionIsConstructed()
    {
        $collection = new Collection('foo');
        $this->assertSame(['foo'], $collection->all());

        $collection = new Collection('{"foo": "bar"}');
        $this->assertSame(['foo' => 'bar'], $collection->all());

        $collection = new Collection(2);
        $this->assertSame([2], $collection->all());

        $collection = new Collection(false);
        $this->assertSame([false], $collection->all());

        $collection = new Collection(null);
        $this->assertSame([], $collection->all());

        $collection = new Collection;
        $this->assertSame([], $collection->all());
    }

    public function testOffsetAccess()
    {
        $c = new Collection(['name' => 'TimSDK']);
        $this->assertEquals('TimSDK', $c['name']);

        $c['name'] = 'dayle';
        $this->assertEquals('dayle', $c['name']);
        $this->assertTrue(isset($c['name']));

        unset($c['name']);
        $this->assertFalse(isset($c['name']));

        $c[] = 'jason';
        $this->assertEquals('jason', $c[0]);
    }

    public function testArrayAccessOffsetExists()
    {
        $c = new Collection(['foo', 'bar']);
        $this->assertTrue($c->offsetExists(0));
        $this->assertTrue($c->offsetExists(1));
        $this->assertFalse($c->offsetExists(1000));
    }

    public function testArrayAccessOffsetGet()
    {
        $c = new Collection(['foo', 'bar']);
        $this->assertEquals('foo', $c->offsetGet(0));
        $this->assertEquals('bar', $c->offsetGet(1));
    }

    public function testArrayAccessOffsetSet()
    {
        $c = new Collection(['foo', 'foo']);
        $c->offsetSet(1, 'bar');
        $this->assertEquals('bar', $c[1]);
        $c->offsetSet(null, 'qux');
        $this->assertEquals('qux', $c[2]);
    }

    public function testArrayAccessOffsetUnset()
    {
        $c = new Collection(['foo', 'bar']);
        $c->offsetUnset(1);
        $this->assertFalse(isset($c[1]));
    }

    public function testForgetArrayOfKeys()
    {
        $c = new Collection(['foo', 'bar', 'baz']);
        $c->forget([0, 2]);
        $this->assertFalse(isset($c[0]));
        $this->assertFalse(isset($c[2]));
        $this->assertTrue(isset($c[1]));

        $c = new Collection(['name' => 'taylor', 'foo' => 'bar', 'baz' => 'qux']);
        $c->forget(['foo', 'baz']);
        $this->assertFalse(isset($c['foo']));
        $this->assertFalse(isset($c['baz']));
        $this->assertTrue(isset($c['name']));

        $c = new Collection(['name' => 'taylor', 'foo' => 'bar', 'baz' => 'qux']);
        $c->forget('foo');
        $this->assertFalse(isset($c['foo']));
    }

    public function testCountable()
    {
        $c = new Collection(['foo', 'bar']);
        $this->assertCount(2, $c);
    }

    public function testIterable()
    {
        $c = new Collection(['foo']);
        $this->assertInstanceOf('ArrayIterator', $c->getIterator());
        $this->assertEquals(['foo'], $c->getIterator()->getArrayCopy());
    }

    public function testGetArrayableItems()
    {
        $collection = new Collection;
        $class = new ReflectionClass($collection);
        $method = $class->getMethod('getArrayableItems');
        $method->setAccessible(true);

        $items = new TestJsonSerializeObject;
        $array = $method->invokeArgs($collection, [$items]);
        $this->assertSame(['foo' => 'bar'], $array);

        $items = new Collection(['foo' => 'bar']);
        $array = $method->invokeArgs($collection, [$items]);
        $this->assertSame(['foo' => 'bar'], $array);

        $items = ['foo' => 'bar'];
        $array = $method->invokeArgs($collection, [$items]);
        $this->assertSame(['foo' => 'bar'], $array);
    }

    public function testSerializeAndUnserialize()
    {
        $c = new Collection(['foo' => 'bar']);
        $serialize = $c->serialize();
        $this->assertInternalType('string', $serialize);

        $c->unserialize($serialize);
        $this->assertSame(['foo' => 'bar'], $c->all());
    }

    public function testMerge()
    {
        $c = new Collection(['foo' => 'bar']);
        $c->merge(['key' => 'value']);

        $this->assertSame(['foo' => 'bar', 'key' => 'value'], $c->all());
    }
}

class TestArrayAccessImplementation implements ArrayAccess
{
    private $arr;
    public function __construct($arr)
    {
        $this->arr = $arr;
    }
    public function offsetExists($offset)
    {
        return isset($this->arr[$offset]);
    }
    public function offsetGet($offset)
    {
        return $this->arr[$offset];
    }
    public function offsetSet($offset, $value)
    {
        $this->arr[$offset] = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->arr[$offset]);
    }
}

class TestJsonSerializeObject implements JsonSerializable
{
    public function jsonSerialize()
    {
        return ['foo' => 'bar'];
    }
}
