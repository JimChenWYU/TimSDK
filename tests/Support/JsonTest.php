<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 3:05 PM
 */

namespace TimSDK\Tests\Support;

use TimSDK\Core\Exceptions\JsonParseException;
use TimSDK\Support\Json;
use TimSDK\Tests\TestCase;

class JsonTest extends TestCase
{
    public function testEncode()
    {
        $array = ['foo' => 'bar'];

        $this->assertEquals('{"foo":"bar"}', Json::encode($array));

        try {
            Json::encode('');
        } catch (\Exception $e) {
            $this->assertInstanceOf(JsonParseException::class, $e);
        }
    }

    public function testDecode()
    {
        $json = '{"foo":"bar"}';

        $this->assertEquals(['foo' => 'bar'], Json::decode($json, true));

        try {
            Json::decode('{"foo":"bar"');
        } catch (\Exception $e) {
            $this->assertInstanceOf(JsonParseException::class, $e);
        }
    }
}
