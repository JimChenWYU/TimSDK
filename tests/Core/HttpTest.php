<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 1:03 PM
 */
namespace TimSDK\Tests\Core;

use TimSDK\Core\Http;
use TimSDK\Tests\TestCase;
use GuzzleHttp\Client as HttpClient;

class HttpTest extends TestCase
{
    public function testClient()
    {
        $h = new Http();

        $this->assertInstanceOf(HttpClient::class, $h->getClient());
    }

    public function testPost()
    {
        Http::setDefaultOptions([
            'verify' => false
        ]);

        $h = new Http();
        $url = 'https://httpbin.org/post';
        $response = $h->post($url);
        $ret = $h->parseJSON($response);

        $this->assertInternalType('array', $ret);
        $this->assertArrayHasKey('url', $ret);
        $this->assertEquals($url, $ret['url']);
    }
}
