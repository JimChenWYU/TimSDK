<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 11:31 AM
 */

namespace TimSDK\Tests\Core;

use GuzzleHttp\Client;
use TimSDK\Container\ServiceContainer;
use TimSDK\Core\AbstractTimSDKAPI;
use TimSDK\Support\Collection;
use TimSDK\Tests\TestCase;

class TimSDKAPITest extends TestCase
{
    public function testParseJSON()
    {
        $t = new TimSDKAPI(ServiceContainer::getInstance());
        $t->setHttpClient(new Client());
        $url = 'https://httpbin.org/post';
        $c = $t->parseJSON('post', [
            $url,
            ['verify' => false]
        ]);

        $this->assertInstanceOf(Collection::class, $c);
        $this->assertEquals($url, $c->get('url'));
    }
}

class TimSDKAPI extends AbstractTimSDKAPI
{
}
