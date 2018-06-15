<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 11:20 AM
 */

namespace TimSDK\Tests\Support;

use TimSDK\Support\Str;
use TimSDK\Tests\TestCase;

class StrTest extends TestCase
{
    public function testStartsWith()
    {
        $this->assertTrue(Str::startsWith('Hello World', ['foo', 'Hello']));
        $this->assertTrue(Str::startsWith('Hello World', 'Hello'));
        $this->assertFalse(Str::startsWith('Hello World', 'foo'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(Str::endsWith('Hello World', ['Worlds', 'World']));
        $this->assertTrue(Str::endsWith('Hello World', 'World'));
        $this->assertFalse(Str::endsWith('Hello World', 'Worlds'));
    }
}
